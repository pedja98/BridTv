<?php require_once "./include/video.php"; ?>
<?php require_once "./include/color.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <title>BridTV</title>
</head>

<body>
    <div class="content">
        <table>
            <tr>
                <th>Title</th>
                <th>Image</th>
                <th>Thumbnail</th>
                <th>Duration</th>
                <th>Publish</th>
            </tr>
            <?php
            foreach ($videos as $video) {
            ?>
                <tr class="<?php echo is_numeric($video["duration"]) ? getColorStyle(intval($video["duration"])) : ""; ?>">
                    <td><?php echo $video["name"]; ?></td>
                    <td><img class="video-img" src="<?php echo $video["image"]; ?>" alt="image"></td>
                    <td><img class="video-img" src="<?php echo $video["thumbnail"]; ?>" alt="thumbnail"></td>
                    <td><?php echo $video["duration"]; ?></td>
                    <td><?php echo $video["publish"]; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>