<!DOCTYPE html>
<html>
    <head>
      <?php include 'html-head.php'; ?>
      <script type="text/javascript" src="js/contact.js"></script>
    </head>

<body>
<div id="content">
<?php include 'nav.php'; ?>
<?php include 'header.php'; ?>
    <section>
        <article>
            <form action="process.php" method="post">
                Send us a message!<br>
                <div class="field">
                    <label for="name">Name: </label>
                    <input  placeholder="Please enter your name" tabindex="1" type="text" name="name" required autofocus>
                </div>
                              
                <div class="field">
                    <label for="email">Email: </label>
                    <input  placeholder="Please enter your email address" tabindex="2" type="email" name="email" required>
                </div>
                
                <div class="field">
                    <label for="phone">Phone: </label>
                    <input  placeholder="Please enter your number" tabindex="3" type="tel" name="phone">
                </div>
                
                <div class="field">
                    <label for="message">Message: </label>
                    <textarea placeholder="Please enter your message" tabindex="4" name="message" required></textarea>   
                </div>
                
                <div class="field">
                    <label>*What is 3+2? (Anti-spam)</label>
                    <input name="human" placeholder="Type Here">
                </div>
                
                <div id="result" class="field">
                    <input id="submit" name="submit" type="submit" value="Submit" onclick="changeText();" tabindex="5">    
                </div>
            </form>
        </article>
    </section>
<?php include 'footer.php'; ?>
</div>
</body>

</html>