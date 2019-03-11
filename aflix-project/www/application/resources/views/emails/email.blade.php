<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Welcome To aflix.tv</h2>

        <div>

            Thanks for creating an account with aflix.tv
			<br>
            <Br>
			<b>Your User Name :</b>  <?php echo $username;?>
			<br>
                                                                <br>
			<b>Your can reset Your  Password By This Link :</b>  <a href="{{ url('/password/reset') }}">Reset</a>

        </div>

    </body>
</html>
