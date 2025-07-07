# Система управления баннерами (Frontend)

## Обзор

Система управления баннерами позволяет гибко настраивать отображение баннеров на фронтенде через конфигурационные файлы.

## Структура

### Компоненты

- `BannerManager` - основной класс для работы с баннерами
- `BannersWidget` - виджет для отображения баннеров

### Позиции баннеров

- `left` - левая колонка
- `right` - правая колонка  
- `top` - верхняя часть страницы
- `bottom` - нижняя часть страницы

## Использование

### 1. В представлениях

```php
<?= BannersWidget::widget([
    'position' => 'left',
    'containerClass' => 'd-flex flex-column align-items-center gap-4',
    'bannerClass' => 'border rounded p-1 w-100 text-center bg-light',
    'imageClass' => 'img-fluid',
]) ?>
```

### 2. Программно

```php
use common\components\BannerManager;

// Получить баннеры для позиции
$banners = BannerManager::getBanners('left');

// Проверить наличие баннеров
if (BannerManager::hasBanners('left')) {
    // Показать баннеры
}

// Получить HTML
$html = BannerManager::renderBanners('left');
```

## Конфигурация

### Структура баннера

```php
[
    'src' => '/path/to/image.jpg',
    'alt' => 'Alt текст',
    'title' => 'Заголовок',
    'url' => 'https://example.com', // опционально
    'active' => false, // включен/выключен
]
```

### Конфигурация баннеров

Баннеры настраиваются напрямую в файле `frontend/config/params-local.php`:

```php
'banners' => [
    'left' => [
        [
            'src' => '/img/banner/aviso.gif',
            'alt' => 'Баннер 1',
            'title' => 'Aviso',
            'url' => 'https://aviso.com',
            'active' => false,
        ],
        [
            'src' => '/img/banner/profit-center.gif',
            'alt' => 'Баннер 2',
            'title' => 'Profit Center',
            'url' => 'https://profit-center.com',
            'active' => false,
        ],
        [
            'src' => '/img/banner/vie-faucet.jpg',
            'alt' => 'Баннер 3',
            'title' => 'Vie Faucet',
            'url' => 'https://vie-faucet.com',
            'active' => false,
        ],
    ],
],
```



## Включение баннеров

По умолчанию все баннеры выключены. Для их включения:

1. **Включить общий показ баннеров** в `frontend/config/params-local.php`:
   ```php
   'showBanners' => true,
   ```

2. **Включить конкретные баннеры** изменив `active` на `true`:
   ```php
   'active' => true,
   ```

## Добавление новых баннеров

### Добавление баннера

Добавьте баннер в `frontend/config/params-local.php`:

```php
'banners' => [
    'left' => [
        // существующие баннеры...
        [
            'src' => '/img/banner/new-banner.jpg',
            'alt' => 'Новый баннер',
            'title' => 'Новый баннер',
            'url' => 'https://example.com',
            'active' => false, // по умолчанию выключен
        ],
    ],
],
```

## Файлы представлений

- `_leftBanners.php` - левые баннеры
- `_rightBanners.php` - правые баннеры
- `_topBanners.php` - верхние баннеры
- `_bottomBanners.php` - нижние баннеры

## Преимущества

1. **Гибкость** - легко добавлять/удалять баннеры
2. **Управляемость** - настройка через конфигурационные файлы
3. **Безопасность** - экранирование HTML
4. **Производительность** - кэширование конфигурации
5. **Переиспользование** - единый виджет для всех позиций 