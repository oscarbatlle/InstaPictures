<?php
/**
 * @author Oscar Batlle <oscarbatlle@gmail.com>
 */
if (!empty($_GET['location']))
{
    $maps_url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($_GET['location']);
    $maps_json = file_get_contents($maps_url);
    $maps_array = json_decode($maps_json, true);
    $lat = $maps_array['results'][0]['geometry']['location']['lat'];
    $lng = $maps_array['results'][0]['geometry']['location']['lng'];
    $instagram_url = 'https://api.instagram.com/v1/media/search?lat=' . $lat . '&lng=' . $lng . '&client_id=<INSERT YOUR INSTAGRAM CLIENT ID HERE>';
    $instagram_json = file_get_contents($instagram_url);
    $instagram_array = json_decode($instagram_json, true);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>REST Application</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"
          media="screen">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="" class="search-form">
                <div class="form-group">
                    <label for="location">Enter location:</label>
                    <input type="text" id="geocomplete" class="form-control" name="location">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary form-control" value="submit"/>
                </div>
            </form>
            <?php
            if (!empty($instagram_array))
            {
                foreach ($instagram_array['data'] as $image)
                {
                    echo '<div class="col-md-6">';
                    echo '<div class="thumbnail">';
                    echo '<p> username: ' . $image['caption']['from']['username'] . '</p>';
                    echo '<p> Full Name: ' . $image['caption']['from']['full_name'] . '</p>';
                    echo '<a href="' . $image['link'] . '"><img class="img-responsive" src="' . $image['images']['low_resolution']['url'] . '" alt="' . $image['caption']['text'] . '"></a>';
                    echo '<div class="caption">';
                    echo '<p>' . $image['caption']['text'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</div>

<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!--Bootstrap JavaScript-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<!-- Autocomplete -->
<script src="js/jquery.geocomplete.js"></script>

<script>
    $(function(){

        $("#geocomplete").geocomplete();

        $("#find").click(function(){
            $("#geocomplete").trigger("geocode");
        });


        $("#examples a").click(function(){
            $("#geocomplete").val($(this).text()).trigger("geocode");
            return false;
        });

    });
</script>
</body>
</html>