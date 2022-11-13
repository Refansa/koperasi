<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @routes
    @vite
    <meta name="naive-ui-style" />
    <meta name="vueuc-style" />
</head>

<body>
    @inertia
</body>

</html>
