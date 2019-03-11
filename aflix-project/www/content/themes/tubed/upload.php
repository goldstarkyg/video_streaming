<form method="post" action="add_file"enctype="multipart/form-data">
<input type="file" name="data">
<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
<input type="submit" name="submit" value="Submit">
</form>