<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo json_encode($_POST);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
</head>
<body>
    <label><input type="checkbox" name="gejala[]" value="1"> A</label>
    <label><input type="checkbox" name="gejala[]" value="2"> B</label>
    <button id="btn">Kirim</button>

    <script>
      $('#btn').click(() => {
        const gejala = $('[name="gejala[]"]:checked').map((_,c)=>c.value).get();
        console.log('Terpilih:', gejala);
        $.ajax({
          type:'POST',
          url:'test_checkbox.php',
          data:{gejala},
          traditional:true,
          success:console.log,
          error:console.error
        });
      });
    </script>
</body>
</html>