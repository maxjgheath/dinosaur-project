<?php
include 'top.php';
?>
<main>
    <h2>Create Table SQL</h2>
    <code>
        CREATE TABLE tblDinosaurSurvey (
            pmkDinosaurSurveyId INT AUTO_INCREMENT PRIMARY KEY,
            fldFirstName varchar(30),
            fldLastName varchar(30),
            fldEmail varchar(50),
            fldFavoriteDinosaur varchar(50),
            fldHomeContinent varchar(50),
        );
    </code>
    <h2>First Insert Statement</h2>
    <code>
        INSERT INTO tblSurvey (
            fldFirstName, 
            fldLastName, 
            fldEmail, 
            fldFavoriteDinosaur, 
            fldHomeContinent, 
            ) 
        VALUES ('John', 'Doe', 'mjheath@uvm.edu', 'trex', 'northAmerica');
    </code>
    <h2>Second Insert Statement</h2>
    <code>
        INSERT INTO tblSurvey (
            fldFirstName, 
            fldLastName, 
            fldEmail, 
            fldFavoriteDinosaur, 
            fldHomeContinent, 
            ) 
        VALUES ('Jon', 'Doh', 'mjheath@uvm.edu', 'trex', 'southAmerica');
    </code>
    <h2>Third Insert Statement</h2>
    <code>
        INSERT INTO tblSurvey (
            fldFirstName, 
            fldLastName, 
            fldEmail, 
            fldFavoriteDinosaur, 
            fldHomeContinent, 
            ) 
        VALUES ('John', 'Dough', 'mjheath@uvm.edu', 'other', 'europe');
    </code>
    <h2>Fourth Insert Statement</h2>
    <code>
        INSERT INTO tblSurvey (
            fldFirstName, 
            fldLastName, 
            fldEmail, 
            fldFavoriteDinosaur, 
            fldHomeContinent, 
            ) 
        VALUES ('Jawn', 'Doah', 'mjheath@uvm.edu', 'triceratops', 'australia');
    </code>
    <h2>Fifth Insert Statement</h2>
    <code>
        INSERT INTO tblSurvey (
            fldFirstName, 
            fldLastName, 
            fldEmail, 
            fldFavoriteDinosaur, 
            fldHomeContinent, 
            ) 
        VALUES ('Jahn', 'Do', 'mjheath@uvm.edu', 'triceratops', 'asia');
    </code>
    <h2>Sixth Insert Statement</h2>
    <code>
        INSERT INTO tblSurvey (
            fldFirstName, 
            fldLastName, 
            fldEmail, 
            fldFavoriteDinosaur, 
            fldHomeContinent, 
            ) 
        VALUES ('John', 'Dogh', 'mjheath@uvm.edu', 'triceratops', 'africa');
    </code>
    <h2>Seventh Insert Statement</h2>
    <code>
        INSERT INTO tblSurvey (
            fldFirstName, 
            fldLastName, 
            fldEmail, 
            fldFavoriteDinosaur, 
            fldHomeContinent, 
            ) 
        VALUES ('Joen', 'Dowh', 'mjheath@uvm.edu', 'triceratops', 'northAmerica');
    </code>
    <h2>Select Statement</h2>
    <code>
        SELECT fldLastName, fldHomeContinent, fldFavoriteDinosaur FROM tblDinosaurSurvey;
    </code>
</main>
<?php include 'footer.php'; ?>