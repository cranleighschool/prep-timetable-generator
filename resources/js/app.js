require('./bootstrap');
import html2canvas from "html2canvas";

html2canvas(document.getElementById('timetable-card')).then(function(canvas) {
    var imageData = canvas.toDataURL("image/png");
    //var newData = imageData.replace(/^data:image\/png/, "data:application/octet-stream");
    document.getElementById('download').setAttribute('href', imageData);
    document.getElementById('hidden-photo').appendChild(canvas)
});
