<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./img/logo.png">
    <title>Validation | CarsMarket</title>
</head>
<body>
    
</body>
</html>
<?php
// إعداد اتصال بقاعدة البيانات
$host = "localhost";
$dbname = "contact_cars";
$username = "root"; // اسم المستخدم لقاعدة البيانات
$password = ""; // كلمة مرور قاعدة البيانات

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}

// التحقق من أن البيانات مرسلة بشكل صحيح
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $city = $_POST['city'];
    $whats = $_POST['whats'];
    $face = $_POST['face'];
    $insta = $_POST['insta'];
    $marque = $_POST['marque'];
    $Prix = $_POST['Prix'];
    $descr = $_POST['descr'];




// إنشاء المجلد إذا لم يكن موجودًا
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);   
    }

    // رفع الصورة الأولى
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . "_1_" . basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            die("فشل رفع الصورة الأولى!");
        }
    }
    
    // رفع الصورة الثانية
    $image2Path = null;
    if (isset($_FILES['image2']) && $_FILES['image2']['error'] == 0) {
        $image2Name = time() . "_2_" . basename($_FILES['image2']['name']);
        $image2Path = $uploadDir . $image2Name;

        if (!move_uploaded_file($_FILES['image2']['tmp_name'], $image2Path)) {
            die("فشل رفع الصورة الثانية!");
        }
    }
    // رفع الصورة الثالثة
    $image3Path = null;
    if (isset($_FILES['image3']) && $_FILES['image3']['error'] == 0) {
        $image3Name = time() . "_3_" . basename($_FILES['image3']['name']);
        $image3Path = $uploadDir . $image3Name;

        if (!move_uploaded_file($_FILES['image3']['tmp_name'], $image3Path)) {
            die("فشل رفع الصورة الثالثة!");
        }
    }
    // رفع الصورة الرابعة
    $image4path = null;
    if (isset($_FILES['image4']) && $_FILES['image4']['error'] == 0) {
        $image4Name = time() . "_4_" . basename($_FILES['image4']['name']);
        $image4path= $uploadDir . $image4Name;

        if (!move_uploaded_file($_FILES['image4']['tmp_name'], $image4path)) {
            die("فشل رفع الصورة الشخصية!");
        }
    }

    // إدخال البيانات في قاعدة البيانات
    $sql = "INSERT INTO users (name, surname, city, whats, face , insta, image_path, marque, Prix, descr, image_path_2, image_path_3, image_path_4) 
            VALUES (:name, :surname, :city, :whats, :face, :insta, :image_path, :marque, :Prix , :descr, :image_path_2, :image_path_3 , :image_path_4)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':surname' => $surname,
        ':city' => $city,
        ':whats' => $whats,
        ':face' => $face,
        ':insta' => $insta,
        ':marque' => $marque,
        ':Prix' => $Prix,
        ':descr' => $descr,
        ':image_path' => $imagePath,
        ':image_path_2' => $image2Path,
        ':image_path_3' => $image3Path,
        ':image_path_4' => $image4path
    ]);

    // echo "تم إرسال البيانات وحفظها بنجاح!";
    echo "
    <div style='
        margin: 200px auto;
        padding: 50px;
        border-radius: 10px;
        background-color: #e7f9ed;
        color: #155724;
        text-align: center;
        font-family: Arial, sans-serif;
        max-width: 400px;
        border: 1px solid #c3e6cb;'>
        <h1 style='margin: 0;'><span style='font-size: 24px;'>✔</span> تم إرسال البيانات وحفظها بنجاح!</h1>
        <p style='margin: 10px 0; font-size: 15px;'>شكرًا على تواصلك معنا. سيتم مراجعة بياناتك قريبًا.</p>
    </div>";
}
?>

