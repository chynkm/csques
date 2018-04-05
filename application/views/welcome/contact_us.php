<center><h1 class="bottom_border">Contact us</h1></center>

<p>Since time is of essence, please read the following guidelines before filling out the form:</p>

<ul>
    <li>Please make sure that the message is clear, brief and concise.</li>
    <li>Begin with your conclusions or recommendations (Please don’t begin with facts and build to conclusions).</li>
    <li>Don’t leave things open-ended. Have a clear "ask”, and clear next steps("solution", if there is any).</li>
    <li>Please do not complete the form until you’re ready to be specific. Do not be vague.</li>
</ul>

<form method="post">
    <div class="row">
        <div class="six columns form_group">
            <label>Name</label>
            <input class="u-full-width" type="text" name="name" placeholder="Name" value="<?php echo populate_value('name', $contact_form); ?>">
            <?php echo form_error('name'); ?>
        </div>
        <div class="six columns form_group">
            <label>Email</label>
            <input class="u-full-width" type="email" name="email" placeholder="Email" value="<?php echo populate_value('email', $contact_form); ?>">
            <?php echo form_error('email'); ?>
        </div>
    </div>
    <div class="form_group">
        <label>Message</label>
        <textarea class="u-full-width" placeholder="Message" name="message"><?php echo populate_value('message', $contact_form); ?></textarea>
        <?php echo form_error('message'); ?>
    </div>
    <input class="button" type="submit" value="Send">
</form>

