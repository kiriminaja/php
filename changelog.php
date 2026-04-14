<?php

/**
 * changelog.php — Git-based CHANGELOG.md generator (changelogen-style)
 *
 * Reads conventional-commit messages between tags and produces a grouped,
 * Markdown changelog identical in format to changelogen's output.
 *
 * Supported prefixes:
 *   feat:      → 🚀 Enhancements
 *   fix:       → 🩹 Fixes
 *   refactor:  → 💅 Refactors
 *   perf:      → 🏎 Performance
 *   test:      → ✅ Tests
 *   docs:      → 📖 Documentation
 *   chore:     → 🏡 Chore
 *   build:     → 📦 Build
 *   ci:        → 🤖 CI
 *   style:     → 🎨 Styles
 */

$repoUrl = 'https://github.com/kiriminaja/php';
$baseDir = dirname(__FILE__);
$changelogFile = $baseDir . '/CHANGELOG.md';
$composerFile  = $baseDir . '/composer.json';

// ---------------------------------------------------------------------------
// Author → GitHub username map (email or name → username)
// Entries here take priority. GitHub noreply emails are auto-detected.
// ---------------------------------------------------------------------------
$authorMap = [
    'yanuaraditia@outlook.com'           => 'yanuaraditia',
    'yanuar.aditia@students.amikom.ac.id'=> 'yanuaraditia',
    'daewu.bintara1996@gmail.com'        => 'daewu14',
    'totoprayogo1916@gmail.com'          => 'totoprayogo1916',
    'muhadifff@gmail.com'                => 'muhadifff',
    'dipaferdian2@gmail.com'             => 'dipaferdian',
    'nabiel.p@students.amikom.ac.id'     => 'nabilizzul',
    'anggy.pratama94@gmail.com'          => 'anggyprat',
    'slemania@gmail.com'                 => 'nug1e',
];

// ---------------------------------------------------------------------------
// 1. Gather all tags sorted by version (oldest first)
// ---------------------------------------------------------------------------
$tagsRaw = trim(shell_exec("git -C '{$baseDir}' tag --sort=v:refname 2>/dev/null") ?? '');
$tags = $tagsRaw !== '' ? explode("\n", $tagsRaw) : [];

// Current version from composer.json (used as the "unreleased" version)
$composer = json_decode(file_get_contents($composerFile), true);
$currentVersion = $composer['version'] ?? 'unreleased';

// Build version ranges: [from, to, label]
$ranges = [];
$prev = null;
foreach ($tags as $tag) {
    $ranges[] = [$prev, $tag, $tag];
    $prev = $tag;
}
// Add unreleased range (from latest tag to HEAD)
$ranges[] = [$prev, 'HEAD', "v{$currentVersion}"];

// Reverse so newest is first
$ranges = array_reverse($ranges);

// ---------------------------------------------------------------------------
// 2. Category mapping
// ---------------------------------------------------------------------------
$categories = [
    'feat'     => '🚀 Enhancements',
    'fix'      => '🩹 Fixes',
    'refactor' => '💅 Refactors',
    'perf'     => '🏎 Performance',
    'test'     => '✅ Tests',
    'docs'     => '📖 Documentation',
    'chore'    => '🏡 Chore',
    'build'    => '📦 Build',
    'ci'       => '🤖 CI',
    'style'    => '🎨 Styles',
];

// ---------------------------------------------------------------------------
// 3. Parse commits for each range
// ---------------------------------------------------------------------------

/**
 * Resolve a GitHub username from an email address.
 * 1. Check the manual $authorMap
 * 2. Parse GitHub noreply format: <id>+<user>@users.noreply.github.com
 */
function resolveGitHub(string $email): ?string
{
    global $authorMap;

    // Manual map lookup
    $key = strtolower(trim($email));
    foreach ($authorMap as $mapEmail => $username) {
        if (strtolower($mapEmail) === $key) {
            return $username;
        }
    }

    // GitHub noreply: 12345+username@users.noreply.github.com
    if (preg_match('/^(?:\d+\+)?(.+)@users\.noreply\.github\.com$/i', $email, $m)) {
        return $m[1];
    }

    return null;
}

function getCommits(?string $from = null, string $to = 'HEAD'): array
{
    global $baseDir;
    $range = $from ? "{$from}..{$to}" : $to;
    $format = '%H||%s||%aN||%aE';
    $raw = trim(shell_exec("git -C '{$baseDir}' log {$range} --pretty=format:'{$format}' 2>/dev/null") ?? '');
    if ($raw === '') return [];

    $commits = [];
    foreach (explode("\n", $raw) as $line) {
        $line = trim($line, "'");
        $parts = explode('||', $line, 4);
        if (count($parts) < 4) continue;
        $commits[] = [
            'hash'    => $parts[0],
            'subject' => $parts[1],
            'author'  => $parts[2],
            'email'   => $parts[3],
        ];
    }
    return $commits;
}

function categorize(array $commits, array $categories): array
{
    $grouped = [];
    foreach ($commits as $commit) {
        $subject = $commit['subject'];
        $matched = false;

        // Match conventional commit: type(scope): message  OR  type: message
        if (preg_match('/^(\w+)(?:\(.+?\))?:\s*(.+)$/', $subject, $m)) {
            $type = strtolower($m[1]);
            $message = $m[2];
            if (isset($categories[$type])) {
                $label = $categories[$type];
                $grouped[$label][] = [
                    'message' => ucfirst($message),
                    'hash'    => substr($commit['hash'], 0, 7),
                    'author'  => $commit['author'],
                ];
                $matched = true;
            }
        }

        // Non-conventional commits go to "Other Changes"
        if (!$matched) {
            // Skip merge commits
            if (str_starts_with($subject, 'Merge ')) continue;
            $grouped['Other Changes'][] = [
                'message' => ucfirst($subject),
                'hash'    => substr($commit['hash'], 0, 7),
                'author'  => $commit['author'],
            ];
        }
    }
    return $grouped;
}

// ---------------------------------------------------------------------------
// 4. Build Markdown
// ---------------------------------------------------------------------------
$output = "# Changelog\n";

foreach ($ranges as [$from, $to, $label]) {
    $commits = getCommits($from, $to);
    if (empty($commits)) continue;

    $grouped = categorize($commits, $categories);
    if (empty($grouped)) continue;

    $output .= "\n\n## {$label}\n";

    // Compare link
    if ($from) {
        $output .= "\n[compare changes]({$repoUrl}/compare/{$from}...{$label})\n";
    }

    // Render each category
    foreach ($categories as $catLabel) {
        if (!isset($grouped[$catLabel])) continue;
        $output .= "\n### {$catLabel}\n\n";
        foreach ($grouped[$catLabel] as $entry) {
            $output .= "- {$entry['message']} ([{$entry['hash']}]({$repoUrl}/commit/{$entry['hash']}))\n";
        }
    }
    // Other changes
    if (isset($grouped['Other Changes'])) {
        $output .= "\n### Other Changes\n\n";
        foreach ($grouped['Other Changes'] as $entry) {
            $output .= "- {$entry['message']} ([{$entry['hash']}]({$repoUrl}/commit/{$entry['hash']}))\n";
        }
    }

    // Contributors
    $authors = [];
    foreach ($commits as $c) {
        if (str_starts_with($c['subject'], 'Merge ')) continue;
        $name = $c['author'];
        $email = $c['email'];
        if (!isset($authors[$name])) {
            $authors[$name] = resolveGitHub($email);
        }
    }
    if (!empty($authors)) {
        $output .= "\n### ❤️ Contributors\n\n";
        foreach ($authors as $name => $ghUser) {
            if ($ghUser) {
                $output .= "- {$name} ([@{$ghUser}](https://github.com/{$ghUser}))\n";
            } else {
                $output .= "- {$name}\n";
            }
        }
    }
}

$output .= "\n";

file_put_contents($changelogFile, $output);
echo "   Generated " . count($ranges) . " version(s) in CHANGELOG.md\n";
