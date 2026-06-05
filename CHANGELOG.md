# Changelog


## 2.1.2

[compare changes](https://github.com/kiriminaja/php/compare/2.1.1...2.1.2)

### 🚀 Enhancements

- Add AWB print, COD calculation, and profile services ([f267292](https://github.com/kiriminaja/php/commit/f267292))

### 📖 Documentation

- Return jsdoc ([b2c59e0](https://github.com/kiriminaja/php/commit/b2c59e0))

### ❤️ Contributors

- Yanuar
- yan-ad ([@yanuaraditia](https://github.com/yanuaraditia))


## 2.1.1

[compare changes](https://github.com/kiriminaja/php/compare/2.1.0...2.1.1)

### 🚀 Enhancements

- Add multi-item volumetric calculator ([6a755fd](https://github.com/kiriminaja/php/commit/6a755fd))
- Add CodeIgniter 4 integration ([be8f007](https://github.com/kiriminaja/php/commit/be8f007))
- Add credit balance API ([8776554](https://github.com/kiriminaja/php/commit/8776554))
- Add optional items array to express request_pickup package ([f0bd1b6](https://github.com/kiriminaja/php/commit/f0bd1b6))

### 📖 Documentation

- Convert ShippingPriceData/ShippingFullPriceData comments to PHPDoc ([ca7a19f](https://github.com/kiriminaja/php/commit/ca7a19f))
- Convert inline trailing comments to PHPDoc blocks ([bbbdf77](https://github.com/kiriminaja/php/commit/bbbdf77))

### 🏡 Chore

- V2.1.1 ([bb0769b](https://github.com/kiriminaja/php/commit/bb0769b))

### ❤️ Contributors

- Yanuar Aditia ([@yanuaraditia](https://github.com/yanuaraditia))


## 2.1.0

[compare changes](https://github.com/kiriminaja/php/compare/2.0.0...2.1.0)

### 🚀 Enhancements

- Add Laravel integration with cache store support ([c380a59](https://github.com/kiriminaja/php/commit/c380a59))
- Remove const since it doesn't supported on older php ([630cf2d](https://github.com/kiriminaja/php/commit/630cf2d))
- Add support for custom base URL in KiriminAjaConfig ([83d2cbf](https://github.com/kiriminaja/php/commit/83d2cbf))
- Add ExpressService, InstantService, and InstantVehicle enums ([02bf365](https://github.com/kiriminaja/php/commit/02bf365))
- Improve readme ([2141837](https://github.com/kiriminaja/php/commit/2141837))
- Add example project ([0af0bb2](https://github.com/kiriminaja/php/commit/0af0bb2))

### 🩹 Fixes

- Update config reference for Laravel cache store support ([df17ef9](https://github.com/kiriminaja/php/commit/df17ef9))
- Backward compability issues ([4b681ad](https://github.com/kiriminaja/php/commit/4b681ad))
- Rc on pr review ([5ea9ac3](https://github.com/kiriminaja/php/commit/5ea9ac3))
- Adjust formatting of available routes in README ([27877fe](https://github.com/kiriminaja/php/commit/27877fe))

### 💅 Refactors

- Update cache put method to accept mixed value type and adjust related tests ([23f2d35](https://github.com/kiriminaja/php/commit/23f2d35))

### ✅ Tests

- Update config namespacing ([044b768](https://github.com/kiriminaja/php/commit/044b768))
- Update tests/Laravel/KiriminAjaServiceProviderTest.php ([be0b1d9](https://github.com/kiriminaja/php/commit/be0b1d9))
- Update src/Base/Config/Cache/FileCacheStore.php ([002c387](https://github.com/kiriminaja/php/commit/002c387))
- Update tests/Laravel/helpers.php ([f35a4ad](https://github.com/kiriminaja/php/commit/f35a4ad))
- Update tests/Laravel/KiriminAjaServiceProviderTest.php ([3987047](https://github.com/kiriminaja/php/commit/3987047))

### 🏡 Chore

- V2.1.0 ([80c2c87](https://github.com/kiriminaja/php/commit/80c2c87))
- Update changelog for v2.0.0 release ([965ecfe](https://github.com/kiriminaja/php/commit/965ecfe))

### Other Changes

- Update src/Contracts/CacheStoreContract.php ([b3df160](https://github.com/kiriminaja/php/commit/b3df160))
- Update src/Base/Config/Cache/LaravelCacheStore.php ([4fced52](https://github.com/kiriminaja/php/commit/4fced52))
- Refactor!: remove useInstant constructor since base-url already support all ([ef60043](https://github.com/kiriminaja/php/commit/ef60043))

### ❤️ Contributors

- Yanuar Aditia ([@yanuaraditia](https://github.com/yanuaraditia))
- Yanuar ([@yanuaraditia](https://github.com/yanuaraditia))


## 2.0.0

[compare changes](https://github.com/kiriminaja/php/compare/1.3.4...2.0.0)

### 🏡 Chore

- V2.0.0 ([f7353c5](https://github.com/kiriminaja/php/commit/f7353c5))

### ❤️ Contributors

- Yanuar Aditia ([@yanuaraditia](https://github.com/yanuaraditia))


## 1.3.4

[compare changes](https://github.com/kiriminaja/php/compare/1.3.3...1.3.4)

### 🚀 Enhancements

- Update minimum php version to 8.1 since 8.0 eol at 2023 ([d4aca76](https://github.com/kiriminaja/php/commit/d4aca76))
- Implement release chain config ([4db758b](https://github.com/kiriminaja/php/commit/4db758b))
- Enhance README with new service methods and examples ([b079ac4](https://github.com/kiriminaja/php/commit/b079ac4))
- Implement test case coverage on all new services ([2c5dd42](https://github.com/kiriminaja/php/commit/2c5dd42))
- Update api to latest coverage version ([0af9283](https://github.com/kiriminaja/php/commit/0af9283))

### 💅 Refactors

- Change rakit/validation into blakvghost/php-validator ([ad1da5e](https://github.com/kiriminaja/php/commit/ad1da5e))

### ✅ Tests

- Remove baseline config ([7e5c261](https://github.com/kiriminaja/php/commit/7e5c261))

### 🏡 Chore

- V1.3.4 ([326d66e](https://github.com/kiriminaja/php/commit/326d66e))
- Remove phpunit.xml.bak from repository and update .gitignore ([a426803](https://github.com/kiriminaja/php/commit/a426803))

### ❤️ Contributors

- Yanuar Aditia ([@yanuaraditia](https://github.com/yanuaraditia))


## 1.3.3

[compare changes](https://github.com/kiriminaja/php/compare/1.3.2...1.3.3)

### 🚀 Enhancements

- Bump version to 1.3.3 ([8d217a6](https://github.com/kiriminaja/php/commit/8d217a6))

### ❤️ Contributors

- Yanuar Aditia ([@yanuaraditia](https://github.com/yanuaraditia))


## 1.3.2

[compare changes](https://github.com/kiriminaja/php/compare/1.3.1...1.3.2)

### 📖 Documentation

- Update the readme style to more clear to user ([3185c6e](https://github.com/kiriminaja/php/commit/3185c6e))

### ❤️ Contributors

- Yanuar Aditia ([@yanuaraditia](https://github.com/yanuaraditia))


## 1.3.1

[compare changes](https://github.com/kiriminaja/php/compare/1.3.0...1.3.1)

### 🚀 Enhancements

- Bump version to 1.3.1 ([82c7ddc](https://github.com/kiriminaja/php/commit/82c7ddc))

### 🩹 Fixes

- The script attempts to write a cache file to /tmp, which returns a permission denied error Fixes #46 ([497b295](https://github.com/kiriminaja/php/commit/497b295))

### 📖 Documentation

- Update readme formatter ([943ce6d](https://github.com/kiriminaja/php/commit/943ce6d))

### ❤️ Contributors

- Yanuar Aditia ([@yanuaraditia](https://github.com/yanuaraditia))


## 1.3.0

[compare changes](https://github.com/kiriminaja/php/compare/1.2.5...1.3.0)

### Other Changes

- Update php.yml test ([800f554](https://github.com/kiriminaja/php/commit/800f554))
- Update README.md ([d2f6d57](https://github.com/kiriminaja/php/commit/d2f6d57))
- Update .gitattributes ([4081120](https://github.com/kiriminaja/php/commit/4081120))
- Update README.md ([a042da8](https://github.com/kiriminaja/php/commit/a042da8))
- Update README.md ([e009681](https://github.com/kiriminaja/php/commit/e009681))
- Update README.md ([c87f5a4](https://github.com/kiriminaja/php/commit/c87f5a4))
- Update README.md ([b1046b2](https://github.com/kiriminaja/php/commit/b1046b2))
- Update .github/workflows/php.yml ([44d7b19](https://github.com/kiriminaja/php/commit/44d7b19))
- Update php.yml ([a4cac26](https://github.com/kiriminaja/php/commit/a4cac26))
- Update php.yml ([b11b76c](https://github.com/kiriminaja/php/commit/b11b76c))
- Update composer.json ([b6266ca](https://github.com/kiriminaja/php/commit/b6266ca))
- `refactor(readme): update request pickup example for clarity` ([2670395](https://github.com/kiriminaja/php/commit/2670395))
- Update php.yml ([85880fd](https://github.com/kiriminaja/php/commit/85880fd))
- Fix : Set default value of 'note' property to an empty string. ([32f9be8](https://github.com/kiriminaja/php/commit/32f9be8))
- Fix : Set default value of 'note' property to an empty string. ([ec34225](https://github.com/kiriminaja/php/commit/ec34225))
- Fix : Refactor package assignment in pickup object setup ([2ebd1ca](https://github.com/kiriminaja/php/commit/2ebd1ca))
- Feat : Update request pickup to version v6.1 ([6488df7](https://github.com/kiriminaja/php/commit/6488df7))
- Feat : Update API pricing to use version 6.1 ([0ba45e7](https://github.com/kiriminaja/php/commit/0ba45e7))
- Add .gitattributes ([3c1dea1](https://github.com/kiriminaja/php/commit/3c1dea1))

### ❤️ Contributors

- Yanuar ([@yanuaraditia](https://github.com/yanuaraditia))
- muhadifff ([@muhadifff](https://github.com/muhadifff))
- Toto ([@totoprayogo1916](https://github.com/totoprayogo1916))


## 1.2.5

[compare changes](https://github.com/kiriminaja/php/compare/1.2.4...1.2.5)

### Other Changes

- Bump to 1.2.5 ([3f18865](https://github.com/kiriminaja/php/commit/3f18865))

### ❤️ Contributors

- yanuar ([@yanuaraditia](https://github.com/yanuaraditia))


## 1.2.4

[compare changes](https://github.com/kiriminaja/php/compare/1.2.3...1.2.4)

### Other Changes

- Dont forgot to bump version ([baf6ae3](https://github.com/kiriminaja/php/commit/baf6ae3))
- Update staging ([6d68260](https://github.com/kiriminaja/php/commit/6d68260))
- Update sandbox & production url ([469250a](https://github.com/kiriminaja/php/commit/469250a))
- KAV-353: Add Lat Lng Support for Lion Parcel ([725a3cd](https://github.com/kiriminaja/php/commit/725a3cd))
- KAV-353: SDK Update Lat Lng Request Pickup ([80d7dd8](https://github.com/kiriminaja/php/commit/80d7dd8))

### ❤️ Contributors

- yanuar ([@yanuaraditia](https://github.com/yanuaraditia))
- Nabil Izzullah ([@nabilizzul](https://github.com/nabilizzul))


## 1.2.3

[compare changes](https://github.com/kiriminaja/php/compare/1.2.2...1.2.3)

### Other Changes

- Fix psr-4 ([9870e67](https://github.com/kiriminaja/php/commit/9870e67))
- Update mockery repo ([b811eab](https://github.com/kiriminaja/php/commit/b811eab))
- Fix method #30 ([ac7a109](https://github.com/kiriminaja/php/commit/ac7a109))
- Create CODE_OF_CONDUCT.md ([af65a56](https://github.com/kiriminaja/php/commit/af65a56))

### ❤️ Contributors

- yanuar ([@yanuaraditia](https://github.com/yanuaraditia))
- Yanuar Aditia ([@yanuaraditia](https://github.com/yanuaraditia))


## 1.2.2

[compare changes](https://github.com/kiriminaja/php/compare/1.2.0...1.2.2)

### Other Changes

- Increase plugin version ([8af64e3](https://github.com/kiriminaja/php/commit/8af64e3))
- Fixing bugs on #27 ([c72b142](https://github.com/kiriminaja/php/commit/c72b142))
- Fixing composer update ([7682328](https://github.com/kiriminaja/php/commit/7682328))
- Update scheme ([d367598](https://github.com/kiriminaja/php/commit/d367598))
- Update cache mode ([59216e1](https://github.com/kiriminaja/php/commit/59216e1))

### ❤️ Contributors

- yanuar ([@yanuaraditia](https://github.com/yanuaraditia))


## 1.2.0

[compare changes](https://github.com/kiriminaja/php/compare/1.1.0...1.2.0)

### Other Changes

- Hotfix on version number ([2328c26](https://github.com/kiriminaja/php/commit/2328c26))
- Add instant ([c5fddce](https://github.com/kiriminaja/php/commit/c5fddce))
- Fix cache issue ([9f75fcf](https://github.com/kiriminaja/php/commit/9f75fcf))
- Update php 7.4 bump ([dd24814](https://github.com/kiriminaja/php/commit/dd24814))

### ❤️ Contributors

- yanuar ([@yanuaraditia](https://github.com/yanuaraditia))


## 1.1.0

[compare changes](https://github.com/kiriminaja/php/compare/1.0.7...1.1.0)

### Other Changes

- Version bump ([9eafa2d](https://github.com/kiriminaja/php/commit/9eafa2d))
- Bump php version to 7.4 ([5568a29](https://github.com/kiriminaja/php/commit/5568a29))
- KAJ-2373: set fullpriceshipping data ([dd87197](https://github.com/kiriminaja/php/commit/dd87197))
- KAJ-2373: set fullpriceshipping data ([cd8ca69](https://github.com/kiriminaja/php/commit/cd8ca69))
- Update .gitignore ([14c2123](https://github.com/kiriminaja/php/commit/14c2123))
- Update README.md ([2f0a4d6](https://github.com/kiriminaja/php/commit/2f0a4d6))
- Update README.md ([0d4df70](https://github.com/kiriminaja/php/commit/0d4df70))
- Funding yaml remove ([a068f85](https://github.com/kiriminaja/php/commit/a068f85))
- Funding yaml ([e3a7e73](https://github.com/kiriminaja/php/commit/e3a7e73))
- Update README.md ([83e00fa](https://github.com/kiriminaja/php/commit/83e00fa))
- Update README.md ([047a477](https://github.com/kiriminaja/php/commit/047a477))
- Update README.md ([f3e0996](https://github.com/kiriminaja/php/commit/f3e0996))
- KAJ-2373: add fullShippingPrice sdk feature ([6b966cf](https://github.com/kiriminaja/php/commit/6b966cf))

### ❤️ Contributors

- yanuar ([@yanuaraditia](https://github.com/yanuaraditia))
- dipaferdian ([@dipaferdian](https://github.com/dipaferdian))
- nug1e ([@nug1e](https://github.com/nug1e))
- Yanuar Aditia ([@yanuaraditia](https://github.com/yanuaraditia))


## 1.0.7

[compare changes](https://github.com/kiriminaja/php/compare/1.0.2-beta...1.0.7)

### Other Changes

- Fixing increment version on composer.json ([a0acbc8](https://github.com/kiriminaja/php/commit/a0acbc8))
- Fixing increment version on composer.json ([613c34d](https://github.com/kiriminaja/php/commit/613c34d))
- Remove idea ([7f91bd9](https://github.com/kiriminaja/php/commit/7f91bd9))
- Update readme ([0639473](https://github.com/kiriminaja/php/commit/0639473))
- Hotfix/feature/refactory-unit-testing: fixing validation and unit testing ([14ac49e](https://github.com/kiriminaja/php/commit/14ac49e))
- Fixing readme.md ([a02f290](https://github.com/kiriminaja/php/commit/a02f290))
- Fixing validation get payment ([c5f6318](https://github.com/kiriminaja/php/commit/c5f6318))
- TrackingService ([71ed554](https://github.com/kiriminaja/php/commit/71ed554))
- ScheduleService ([92f1ded](https://github.com/kiriminaja/php/commit/92f1ded))
- RequestPickupService ([5841212](https://github.com/kiriminaja/php/commit/5841212))
- PriceService ([6840aea](https://github.com/kiriminaja/php/commit/6840aea))
- GetPaymentService ([1a353fb](https://github.com/kiriminaja/php/commit/1a353fb))
- CancelShippingService ([cb8777a](https://github.com/kiriminaja/php/commit/cb8777a))
- SetWhitelistExpeditionService ([59ed35b](https://github.com/kiriminaja/php/commit/59ed35b))
- SetCallbackService ([86bcf71](https://github.com/kiriminaja/php/commit/86bcf71))
- ProvinceService ([b426957](https://github.com/kiriminaja/php/commit/b426957))
- DistrictService ([38d7f35](https://github.com/kiriminaja/php/commit/38d7f35))
- DistrictByNameService ([681dcc2](https://github.com/kiriminaja/php/commit/681dcc2))
- CityService ([401e065](https://github.com/kiriminaja/php/commit/401e065))
- Update README.md ([21c34f6](https://github.com/kiriminaja/php/commit/21c34f6))
- Update composer.json ([0eba604](https://github.com/kiriminaja/php/commit/0eba604))
- Update README.md ([35167b3](https://github.com/kiriminaja/php/commit/35167b3))
- Update README.md ([d059d94](https://github.com/kiriminaja/php/commit/d059d94))
- Improve details ([a8c8b95](https://github.com/kiriminaja/php/commit/a8c8b95))
- Create LICENSE ([622ff4d](https://github.com/kiriminaja/php/commit/622ff4d))
- Update README.md ([9f6e628](https://github.com/kiriminaja/php/commit/9f6e628))
- Update README.md ([f6f1a04](https://github.com/kiriminaja/php/commit/f6f1a04))

### ❤️ Contributors

- Daewu ([@daewu14](https://github.com/daewu14))
- yanuar ([@yanuaraditia](https://github.com/yanuaraditia))
- dipaferdian ([@dipaferdian](https://github.com/dipaferdian))
- anggy ([@anggyprat](https://github.com/anggyprat))
- Daewu Bintara ([@daewu14](https://github.com/daewu14))
- Yanuar Aditia ([@yanuaraditia](https://github.com/yanuaraditia))


## 1.0.2-beta

### Other Changes

- Fixing versioning ([5b40044](https://github.com/kiriminaja/php/commit/5b40044))
- Fixing autoload-dev ([d348814](https://github.com/kiriminaja/php/commit/d348814))
- First commit ([38f012f](https://github.com/kiriminaja/php/commit/38f012f))

### ❤️ Contributors

- Daewu ([@daewu14](https://github.com/daewu14))

