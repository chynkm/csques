<html>
<head>
<style type="text/css">
.hidden {
  display: none;
}
.xfeed_btn {
  position: fixed;
  right: 0px;
  bottom: 0px;
}
</style>
</head>
<body>
<img src="<?php echo asset_url('img/xfeed_icon.png'); ?>" alt="xfeed" class="xfeed_btn" id="xfeed_button" width="50px">
<div class="feedback_form hidden">
    <textarea class="feedback"></textarea>
    <input type="button" class="submit" value="submit">
</div>
</body>
<script src="<?php echo asset_url('js/xfeed.js'); ?>"></script>
</html>