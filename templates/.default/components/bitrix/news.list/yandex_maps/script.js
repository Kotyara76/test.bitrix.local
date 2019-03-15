;
if (!window.fitPlacemarks) {
    window.fitPlacemarks = function(map, objects)
    {
        console.log(map, objects);
        map.setBounds(map.geoObjects.getBounds()); // Устанавливаем автомасштаб по всем точкам
    }
}