<?php
include 'top.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dataIsGood = false;
$firstName = '';
$lastName = '';
$email = '';
$favoriteDinosaur = '';
$homeContinent = '';

function getData($field) {
    if(!isset($_POST[$field])) {
        $data = '';
    } else {
        $data = trim($_POST[$field]);
        $data = htmlspecialchars($data);
    }
    return $data;
}
?>
<main>
    <article class="flexbox-layout">
        <section>
            <h2>Dinosaur Survey</h2>
            <figure>
                <picture>
                    <source media="(min-width: 649px)" srcset="images/paleo-wide.jpeg">
                    <source media="(min-width: 501px)" srcset="images/paleo.jpeg">
                    <img alt="Paleontological research in progress." src="images/paleo.jpeg">
                </picture>
                <figcaption>
                    You too can assist with paleontological research.
                    <cite>Anselmo, SR (August 23, 2011).<em>Europasaurus Praeparation</em>[Digital Photograph], Wikimedia Commons, Retrieved from: <a href="https://commons.wikimedia.org/wiki/File:Europasaurus_Praeparation.JPG">https://commons.wikimedia.org/wiki/File:Europasaurus_Praeparation.JPG</a></cite>
                </figcaption>
            </figure>
        </section>
        <section>
            <h3>Form Status</h3>
            <?php
            print '<p>Post Array:</p><pre>';
            print_r($_POST);
            print '</pre>';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $dataIsGood = true;

                $firstName = getData('txtFirstName');
                $firstName = filter_var($firstName, FILTER_SANITIZE_STRING);
                $lastName = getData('txtLastName');
                $lastName = filter_var($lastName, FILTER_SANITIZE_STRING);
                $email = getData('txtEmail');
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                $homeContinent = getData('lstContinent');
                $homeContinent = filter_var($homeContinent, FILTER_SANITIZE_STRING);
                $favoriteDinosaur = getData('radFavoriteDinosaur');
                $favoriteDinosaur = filter_var($favoriteDinosaur, FILTER_SANITIZE_STRING);

                if ($firstName == '') {
                    print '<p class="mistake">Form Error: Please enter your first name in the appropriate text box.</p>';
                    $dataIsGood = false;
                } elseif (!ctype_alnum($firstName)) {
                    print '<p class="mistake">Form Error: Please use only alphanumeric characters for your first name.</p>';
                    $dataIsGood = false;
                }
                if ($lastName == '') {
                    print '<p class="mistake">Form Error: Please enter your last name in the appropriate text box.</p>';
                    $dataIsGood = false;
                } elseif (!ctype_alnum($lastName)) {
                    print '<p class="mistake">Form Error: Please use only alphanumeric characters for your last name.</p>';
                    $dataIsGood = false;
                }
                if ($email == '') {
                    print '<p class="mistake">Form Error: Please enter your email address in the appropriate text box.</p>';
                    $dataIsGood = false;
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    print '<p class="mistake">Form Error: Please check to ensure you have entered a valid email address.</p>';
                    $dataIsGood = false;
                }
                if ($favoriteDinosaur != 'trex' AND $favoriteDinosaur != 'triceratops' AND $favoriteDinosaur != 'apatosaurus' AND $favoriteDinosaur != 'stegosaurus' AND $favoriteDinosaur != 'pteranodon' AND $favoriteDinosaur != 'other') {
                    print '<p class="mistake">Form Error: Please choose a favorite dinosaur using the radio buttons or pick Other / No Preference.</p>';
                }
                if ($homeContinent != 'africa' AND $homeContinent != 'asia' AND $homeContinent != 'australia' AND $homeContinent != 'europe' AND $homeContinent != 'northAmerica' AND $homeContinent != 'southAmerica') {
                    print '<p class="mistake">Form Error: Please select your home continent from the menu.</p>';
                }

                if ($dataIsGood) {
                    try {
                        $sql = 'INSERT INTO tblDinosaurSurvey (fldFirstName, fldLastName, fldEmail, fldFavoriteDinosaur, fldHomeContinent)
                        VALUES (?, ?, ?, ?, ?)';
                        $statement = $pdo->prepare($sql);
                        $params = array($firstName, $lastName, $email, $favoriteDinosaur, $homeContinent);

                        if ($statement->execute($params)) {
                            print '<p>Your response was successfully added to the database.</p>';
                            $to = $email;
                            $from = 'CS 008 Team <mjheath@uvm.edu>';
                            $subject = 'The Dinosaur Project Survey';
                            $mailMessage = '<h1 style="background-color: darkseagreen; font-weight: bold; text-align: center;">The Dinosaur Project Survey Results</h1>';
                            $mailMessage .= '<img style="margin: auto; max-width: 100%; " src="http://mjheath.w3.uvm.edu/cs008/final/images/trex-narrow.jpg">';
                            $mailMessage .= '<p>Dear ' . $firstName . ' ' . $lastName . ', </p>';
                            $mailMessage .= '<p>You are receiving this message because you completed a form on the website of the Dinosaur Project. We would like to thank you for your participation in our research.';
                            $mailMessage .= 'Please have a nice day.</p>';
                            $mailMessage .= '<p>Sincerely,</p>';
                            $mailMessage .= '<p>Max Heath, Creator of the Dinosaur Project </p>';
                            $headers = "MIME-Version: 1.0\r\n";
                            $headers .= "Content-type: text/html; charset=utf-8\r\n";
                            $headers .= "From: " . $from . "\r\n";
                            $mailSent = mail($to, $subject, $mailMessage, $headers);
                            if ($mailSent) {
                                print '<p>A confirmation email has been sent to your provided email address:</p>';
                                print $mailMessage;
                            }
                        } else {
                            print '<p>Your response was not successfully added to the database.</p>';
                            foreach ($params as $param) {
                                $pos = strpos($sql, '?');
                                if ($pos !== false) {
                                    $sql = substr_replace($sql, '"' . $param . '"', $pos, strlen('?'));
                                }
                            }
                            print '<p>' . $sql . '</p>';
                        }
                    } catch (PDOException $e) {
                        print '<p>Your response could not be inserted into the database. For more information, please contact the site administrators.</p>';
                    }

                }
            }
            if ($dataIsGood) {
                print '<h2>Thank you, your information has been received.</h2>';
            }
            ?>
        </section>
        <section>
            <h3>Dinosaur Survey Form</h3>
            <p>
                What is your favorite dinosaur? Help us determine how
                the sociological impact of dinosaurs on the human mind has
                been shaped by geographic location by answering a brief survey.
                Only your last name, continent of origin, and favorite dinosaur
                will ever be shared publicly.
            </p>
            <form id="frmSurvey" method="POST" action="/cs008/final/form.php">
                <fieldset>
                    <legend>Contact and Demographic Info</legend>
                    <p>
                        <input type="text" name="txtFirstName" required id="txtFirstName" value="<?php
                        print $firstName;
                        ?>">
                        <label for="txtFirstName">First Name:</label>
                    </p>
                    <p>
                        <input type="text" name="txtLastName" required id="txtLastName" value="<?php
                        print $lastName;
                        ?>">
                        <label for="txtLastName" id="txtLastName">Last Name:</label>
                    </p>
                    <p>
                        <input type="email" name="txtEmail" required id="txtEmail" value="<?php
                        print $email;
                        ?>">
                        <label for="txtEmail">Email Address:</label>
                    </p>
                    <p>
                        <select name="lstContinent" required id="lstContinent">
                            <option <?php
                            if ($homeContinent == 'africa') {
                                print 'selected';
                            }
                            ?> value="africa">Africa</option>
                            <option <?php
                            if ($homeContinent == 'asia') {
                                print 'selected';
                            }
                            ?> value="asia">Asia</option>
                            <option <?php
                            if ($homeContinent == 'australia') {
                                print 'selected';
                            }
                            ?> value="australia">Australia</option>
                            <option <?php
                            if ($homeContinent == 'europe') {
                                print 'selected';
                            }
                            ?> value="europe">Europe</option>
                            <option <?php
                            if ($homeContinent == 'northAmerica') {
                                print 'selected';
                            }
                            ?> value="northAmerica">North America</option>
                            <option <?php
                            if ($homeContinent == 'southAmerica') {
                                print 'selected';
                            }
                            ?> value="southAmerica">South America</option>
                        </select>
                        <label for="lstContinent">Please select the continent of your country of origin.</label>
                    </p>
                </fieldset>
                <fieldset>
                    <legend>Favorite Dinosaur</legend>
                    <p>Please select your favorite dinosaur.</p>
                    <p>
                        <input type="radio" <?php
                        if ($favoriteDinosaur == 'trex') {
                            print 'checked';
                        }
                        ?> name="radFavoriteDinosaur" required id="radTrex" value="trex">
                        <label for="radTrex">Tyrannosaurus Rex</label>
                    </p>
                    <p>
                        <input type="radio" <?php
                        if ($favoriteDinosaur == 'triceratops') {
                            print 'checked';
                        }
                        ?> name="radFavoriteDinosaur" required id="radTriceratops" value="triceratops">
                        <label for="radTriceratops">Triceratops</label>
                    </p>
                    <p>
                        <input type="radio" <?php
                        if ($favoriteDinosaur == 'apatosaurus') {
                            print 'checked';
                        }
                        ?> name="radFavoriteDinosaur" required id="radApatosaurus" value="apatosaurus">
                        <label for="radApatopsaurus">Apatosaurus</label>
                    </p>
                    <p>
                        <input type="radio" <?php
                        if ($favoriteDinosaur == 'stegosaurus') {
                            print 'checked';
                        }
                        ?> name="radFavoriteDinosaur" required id="radStegosaurus" value="stegosaurus">
                        <label for="radStegosaurus">Stegosaurus</label>
                    </p>
                    <p>
                        <input type="radio" <?php
                        if ($favoriteDinosaur == 'pteranodon') {
                            print 'checked';
                        }
                        ?> name="radFavoriteDinosaur" required id="radPteranodon" value="pteranodon">
                        <label for="radPteranodon">Pteranodon</label>
                    </p>
                    <p>
                        <input type="radio" <?php
                        if ($favoriteDinosaur == 'other') {
                            print 'checked';
                        }
                        ?> name="radFavoriteDinosaur" required id="radOther" value="other">
                        <label for="radOther">Other / No Favorite Dinosaur</label>
                    </p>
                </fieldset>
                <fieldset>
                    <legend>Submit</legend>
                    <input type="submit" value="Submit">
                </fieldset>
            </form>
        </section>
    </article>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
