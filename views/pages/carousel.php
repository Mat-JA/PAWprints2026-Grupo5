<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">

    <title>Carousel Test</title>

    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/carousel.css">
</head>

<body>

    <div id="mi-carousel">

        <img src="https://picsum.photos/id/10/1200/600">
        <img src="https://picsum.photos/id/20/1200/600">
        <img src="https://picsum.photos/id/30/1200/600">
        <img src="https://picsum.photos/id/40/1200/600">

    </div>

    <script src="/assets/js/carousel.js"></script>

    <script>
        new Carousel("#mi-carousel", {transition: "zoom"});
    </script>

</body>

</html>