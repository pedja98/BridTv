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
        <div class="forms">
            <form method="get">
                <div>
                    <h3>Sort:</h3>
                    <select class="input-field" name="video-field" id="video-field">
                        <option value="">None</option>
                        <option value="name">Title</option>
                        <option value="duration">Duration</option>
                        <option value="publish">Publish</option>
                    </select>
                    <select class="input-field" name="sort-type" id="sort-type">
                        <option value="">None</option>
                        <option value="asc">ASC</option>
                        <option value="desc">DESC</option>
                    </select>
                </div>

                <div>
                    <h3>Search by title:</h3>
                    <input autocomplete="off" class="input-field" placeholder="search title" type="text" name="search-title">
                    <select class="input-field" name="search-title-action">
                        <option value="contains">Contains</option>
                        <option value="equal">Equal</option>
                    </select>
                </div>
                <div>
                    <h3>Search by duration:</h3>
                    <input autocomplete="off" class="input-field" placeholder="search duration" type="number" min='0' name="search-duration">
                    <select class="input-field" name="search-duration-action">
                        <option value="eq">=</option>
                        <option value="not_eq">!=</option>
                        <option value="ls">
                            &lt;
                        </option>
                        <option value="ls_eq">
                            &lt;=
                        </option>
                        <option value="gt">></option>
                        <option value="gt_eq">>=</option>
                    </select>
                </div>
                <div class="checkbox">
                    <input class="input-field-checkbox" type="checkbox" name="show-less-than-60" id="show-less-than-60" value="show">
                    <label for="show-less-than-60">Less only than 60</label>
                </div>
                <input class="input-field btn" type="submit" value="Execute" />
            </form>
            <form class="clear-form" action="index.php">
                <input class="input-field" type="submit" value="Clear" />
            </form>
        </div>
        <div class="table-content">
            <?php
            if (isset($_GET['video-field']) && isset($_GET['sort-type'])) {
                usort($videos, function ($video1, $video2) {
                    if ($_GET['sort-type'] === 'asc') {
                        return $video1[strval($_GET['video-field'])] <=> $video2[strval($_GET['video-field'])];
                    } elseif ($_GET['sort-type'] === 'desc') {
                        return $video2[strval($_GET['video-field'])] <=> $video1[strval($_GET['video-field'])];
                    } else {
                        return false;
                    }
                });
            }
            if (isset($_GET['search-title-action']) && isset($_GET['search-title'])) {
                $videos = array_filter($videos, function ($video) {
                    if ($_GET['search-title-action'] === 'contains') {
                        return str_contains($video['name'], $_GET['search-title']);
                    } elseif ($_GET['search-title-action'] === 'equal') {
                        return $video['name'] === $_GET['search-title'];
                    } else {
                        return false;
                    }
                });
            }
            if (isset($_GET['search-duration-action']) && isset($_GET['search-duration']) && $_GET['search-duration']) {
                $videos = array_filter($videos, function ($video) {
                    if ($video['duration'] === null && !is_numeric($video['duration'])) {
                        return false;
                    }
                    switch ($_GET['search-duration-action']) {
                        case 'eq':
                            return  intval($video['duration']) === intval($_GET['search-duration']);
                        case 'not_eq':
                            return  intval($video['duration']) !== intval($_GET['search-duration']);
                        case 'ls':
                            return  intval($video['duration']) < intval($_GET['search-duration']);
                        case 'ls_eq':
                            return  intval($video['duration']) <= intval($_GET['search-duration']);
                        case 'gt':
                            return  intval($video['duration']) > intval($_GET['search-duration']);
                        case 'gt_eq':
                            return  intval($video['duration']) >= intval($_GET['search-duration']);
                        default:
                            return false;
                    }
                });
            }
            if (isset($_GET['show-less-than-60'])) {
                $videos = array_filter($videos, function ($video) {
                    if ($video['duration'] === null && !is_numeric($video['duration'])) {
                        return false;
                    }
                    return intval($video['duration']) < 60;
                });
            }
            if (isset($_GET['video-id'])) {
                $videos = array_filter($videos, function ($video) {
                    if ($_GET['video-id'] === $video['id']) {
                        return false;
                    }
                    return true;
                });
            }
            if (count($videos) > 0) {
            ?>
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Thumbnail</th>
                        <th>Duration</th>
                        <th>Publish</th>
                        <th>Exclude</th>
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
                            <td>
                                <form class="exclude-form" action="GET">
                                    <input type="hidden" id="video-id" name="video-id" value="<?php echo $video["id"]; ?>">
                                    <input class="input-field btn exclude-btn" type="submit" value="Exclude" />
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <h1>NO VIDEO FOUND</h1>
            <?php } ?>
        </div>
    </div>
</body>

</html>