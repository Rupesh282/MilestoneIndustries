<!-- <div class="container"> -->
                <div class="row">
                    <div class="col-12">
                        <h2 class="contact-title">Get in Touch</h2>
                    </div>
                    <div class="col-lg-8">
                        <form class="form-contact" action="contact.php" method="post">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-msg">
                                    <textarea name="message" id="message" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'" placeholder=" Enter Message" required value="<?php echo $_POST['message']; ?>"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-name">
                                        <input  name="name" id="name" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" placeholder="Enter your name" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-email">
                                        <input name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-subject">
                                        <input name="subject" id="subject" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Subject'" placeholder="Enter Subject" required>
                                    </div>
                                </div> 
                                <div class="col-sm-6">
                                    <div class="form-subject">
                                        <input name="cellno" style="width:100%" id="subject" type="text" pattern="[0-9]+" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter you cellno'" placeholder="Cell No." required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <!--<button name="submit" type="submit" class="button button-contactForm boxed-btn-new">Send</button>-->
                                <input type="submit" name="submit" value="SEND">
                            </div>
                        </form>
                    </div>
                    
<?php
    if(isset($_POST['submit'])) {
        require_once 'contact_process.php';
    }
?>
