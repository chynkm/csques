<?php include_once 'db_cors.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body * {
    box-sizing: border-box;
}
input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}
label {
  padding: 5px 12px 5px 0;
  display: inline-block;
}
input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
input[type=submit]:hover {
    background-color: #45a049;
}
.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 1px 20px 10px 20px;
}
.col-100 {
    float: left;
    width: 100%;
    margin-top: 6px;
}
/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}
textarea {
  height: 140px;
}
.submit_row {
  margin-top: 10px;
}
input[type=submit].disabled, input[type=submit].disabled:hover {
  opacity: 0.5;
  pointer-events: none;
}
h2 {
  margin-bottom: 5px;
}
</style>
</head>
<body>
<div class="container">
  <h2>Issue information</h2>
  <form>
    <div class="row">
      <div class="col-100">
        <label for="lname">Comments</label>
      </div>
      <div class="col-100">
        <textarea type="text" id="xfeed_form_comment" name="xfeed_form_comment" placeholder="Comments"></textarea>
      </div>
    </div>
    <div class="row submit_row">
      <input type="submit" value="Create" id="xfeed_form_submit" class="disabled">
    </div>
  </form>
</div>
</body>
</html>
