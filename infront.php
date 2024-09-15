<?php
     //session_start();
     //include("db.php");

    //if (!isset($_SESSION["loggedin"])) {
    //    echo "
    //        <script>
     //        Swal.fire({
     //            title: 'Error',
     //            text: 'Please log in.',
     //            icon: 'error'
     //        }).then(function() {
     //        location.href = 'login.php'
      //       })
      //       </script>";
    //}
    
    //$uid = $_SESSION["id"];
?>
<head>
    <title>Home || Clothing</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/logo/xcon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <style>
        .image-container {
            position: relative;
            display: inline-block;
        }

        .overlay-image {
            position: absolute;
            top: 20px;
            left: 20px;
            pointer-events: auto;
            cursor: pointer;
            resize: both;
            overflow: auto;
            transform-origin: 50% 50%;
        }
    </style>
</head>
<body>
<div class="customade">
    <div class="image-container" ondrop="drop(event)" ondragover="allowDrop(event)">
        <div id="content">
        <img id="backgroundImage" src="images/product/infront.jpg" alt="Background Image" style="width: 300px; height: 300px;">
            <img id="overlayImage" src="" alt="Overlay Image" class="overlay-image" draggable="true"
                ondragstart="drag(event)">
            <br>
        </div>
            <label for="overlayImageUpload"><b>Upload Image:</b></label>
            <input type="file" id="overlayImageUpload" accept="image/*" onchange="displayOverlayImage(event)" required>
            <br>
        <label for="resize">Resize:</label>
        <input type="range" id="resize" min="20" max="300" value="100" oninput="resizeImage()">
        <br>
        <label for="rotate">Rotate:</label>
        <input type="range" id="rotate" min="0" max="360" value="0" oninput="rotateImage()">
        <br>
        <button onclick="captureScreenshot()" class="btn btn-primary">Capture Screenshot</button>
        <a href="customize.php"><button class="btn btn-danger">Back</button></a>
    </div>
</div>


<script>
    function allowDrop(event) {
        event.preventDefault();
    }

    function drag(event) {
        event.dataTransfer.setData("text", event.target.id);
    }

    function drop(event) {
        event.preventDefault();
        const overlay = document.getElementById("overlayImage");
        overlay.style.left = event.clientX - overlay.clientWidth / 2 + 'px';
        overlay.style.top = event.clientY - overlay.clientHeight / 2 + 'px';
    }

    function resizeImage() {
        const resizeValue = document.getElementById("resize").value;
        const overlay = document.getElementById("overlayImage");
        overlay.style.width = resizeValue + 'px';
        overlay.style.height = resizeValue + 'px';
    }

    function rotateImage() {
        const rotateValue = document.getElementById("rotate").value;
        const overlay = document.getElementById("overlayImage");
        overlay.style.transform = "rotate(" + rotateValue + "deg)";
    }

    function displayOverlayImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            const overlayImage = document.getElementById("overlayImage");
            overlayImage.src = e.target.result;
        };

        reader.readAsDataURL(file);
    }

    function captureScreenshot() {
        var element = document.getElementById('content');

        html2canvas(element).then(function(canvas) {
            var imgData = canvas.toDataURL('image/png');
            var link = document.createElement('a');
            link.href = imgData;
            link.download = 'screenshot.png';
            link.click();
        });
    }

    </script>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // PHP server-side code to save the screenshot (you can integrate Puppeteer logic here)
        file_put_contents('screenshot.png', file_get_contents('php://input'));
        echo 'Screenshot saved successfully.';
    }
?>

</body>
