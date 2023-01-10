<?php include("fol-upload.php") ?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="style.css">

  <title>Upload Files & Folders</title>
</head>

<body>

  <div class="container">
    <form action="" method="post" enctype="multipart/form-data" class="mb-3">
      <h3 class="text">Upload file & folder</h3>

      <div class="custom-file">
        <input type="file" name="fileUpload" class="custom" id="chooseFile">
        <label class="custom" for="chooseFile">Select file</label>
      </div>

      <div class="custom-file">
        <input type="file" name="folderUpload" class="custom" id="chooseFolder" webkitdirectory directory >
        <label class="custom" for="chooseFolder">Select folder</label>
      </div>

      <button type="submit" name="submit" class="but0n">
        Upload
      </button>
    </form>

    <!-- Display response messages -->
    <?php if(!empty($resMessage)) {?>
    <div class="alert <?php echo $resMessage['status']?>">
      <?php echo $resMessage['message']?>
    </div>
    <?php }?>
  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

  <script>
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
          $('#imgPlaceholder').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }

    $("#chooseFile").change(function () {
      readURL(this);
    });
  </script>
  <script>
    function displaySelectedFile(inputId) {
      var input = document.getElementById(inputId);
      var selectedFile = input.value;
      alert(selectedFile);
    }
  
    document.getElementById('chooseFile').addEventListener('change', function() {
      displaySelectedFile('chooseFile');
    });
  
    document.getElementById('chooseFolder').addEventListener('change', function() {
      displaySelectedFile('chooseFolder');
    });
  </script>
</body>
</html>  