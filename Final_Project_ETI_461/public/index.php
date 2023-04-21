<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ETI_FINAL</title>
    <link rel = "stylesheet" href="styles.css">
    <?php require_once '../private/login.php'?>  
<body>

<?php 
$conn = new mysqli($hn, $un, $pw, $dn);
    if($conn->connect_error) die('fatal_error 1');
    ?>
    <?php

function ADD_customer($conn){
    $Customer_name = $_POST['Customer_name'];
    $Customer_address = $_POST['Customer_address'];
    $Customer_contact = $_POST['Customer_contact'];
    $Customer_payment = $_POST['Customer_payment'];
    $Customer_Credientials= $_POST['Customer_Credientials'];
    $addQuery2 = "INSERT INTO `customer`(`Customer_name`,`Customer_address`,`Customer_contact`,`Customer_payment`,`Customer_Credientials`) 
        VALUES"."('$Customer_name','$Customer_address','$Customer_contact','$Customer_payment','$Customer_Credientials')";
        $addresult2 = $conn->query($addQuery2);
}
if(array_key_exists('ADD_customer', $_POST)){
    ADD_customer($conn);
}

    /*add reservation Function*/
    /*delete function */
 function cancel_reservation($conn){
    $res_ID = $_POST['res_ID'];
    $deleteQuery = "DELETE FROM reservation WHERE `reservation`.`Reservation_ID` = $res_ID";
    $deleteresult = $conn->query($deleteQuery);
 }
 if(array_key_exists('reservation_ID', $_POST)){
    cancel_reservation($conn);
 }
 function Updated_Customer_Name($conn){
    $cust_name = $_POST['cust_name'];
    $custID = $_POST['cust_ID'];
    if($cust_name && $custID){
    $updatequery = "UPDATE `customer` SET `Customer_name` = '$cust_name' WHERE Customer_ID = $custID";
    $updateresult = $conn->query($updatequery);}
    else{
        echo "bad call";
    }
 }
 if(array_key_exists("Updated_Customer_Name", $_POST)){
    Updated_Customer_Name($conn);
 }
 /*new customer block*/

 function ADD_Reservation($conn){
    $Customer_ID = $_POST['Customer_ID'];
    $Owner_ID = $_POST['Owner_ID'];
    $Property_ID = $_POST['Property_ID'];
    $Total_price = $_POST['Total_price'];
    $Dates_rerserved = $_POST['Dates_reservered'];
    $addQuery = "INSERT INTO reservation (Customer_ID, Owner_ID, Property_ID, Total_price, Dates_reserved) 
    VALUES" ."('$Customer_ID', '$Owner_ID', '$Property_ID', '$Total_price','$Dates_rerserved')";
        $addresult = $conn->query($addQuery);
}
if(array_key_exists('ADD_Reservation', $_POST)){
 ADD_Reservation($conn);
}

?>
    <?php
    /*
    Select * PHP BLOCK
    */
    
    $Selectquery = "SELECT * FROM customer";
    $Selectquery2 = "SELECT * FROM property";
    $Selectquery3 = "SELECT * FROM property_owner";
    $Selectquery4 = "SELECT * FROM reservation";
    $Selectquery5 = "SELECT * FROM recipt";
    $view1 = "SELECT * FROM `state`
    INNER JOIN property_owner ON state.Owner_ID = property_owner.Owner_ID";

    /*3x join query*/
    $joinquery = "SELECT * FROM reservation
    INNER JOIN customer ON reservation.Customer_ID = customer.Customer_ID
    INNER JOIN property_owner ON reservation.Owner_ID = property_owner.Owner_ID
    INNER JOIN property ON reservation.Property_ID = property.Property_ID";
    
    /*recipt join query*/
    $joinquery2 = "SELECT * FROM recipt
    INNER JOIN property ON recipt.Property_ID = property.Property_ID
    INNER JOIN reservation ON recipt.Reservation_ID = reservation.Reservation_ID";

    /* create view 1*/
    
    $Selectresult = $conn->query($Selectquery);
    $Selectresult2 = $conn->query($Selectquery2);
    $Selectresult3 = $conn->query($Selectquery3);
    $Selectresult4 = $conn->query($Selectquery4);
    $Selectresult5 = $conn->query($Selectquery5);
    
    $joinresult = $conn->query($joinquery);
    $joinresult2 = $conn->query($joinquery2);

    $resultview1 = $conn->query($view1);

if(!$Selectresult) die("fatal error 2");
 $rows = $Selectresult->num_rows;
 if(!$Selectresult2) die("fatal error 2");
 $rows = $Selectresult2->num_rows;
 if(!$Selectresult3) die("fatal error 2");
 $rows = $Selectresult3->num_rows;
 if(!$Selectresult5) die("fatal error 2");
 $rows = $Selectresult5->num_rows;
 if(!$joinresult) die("fatal error 2");
 $rows = $joinresult->num_rows;
 if(!$joinresult2) die("fatal error 2");
 $rows = $joinresult2->num_rows;
 if(!$Selectresult4) die("fatal error 2");
 $rows = $Selectresult4->num_rows;

?>
<?php
/* 
JOIN PHP BLOCK
*/

?>
<?php
/*
add customer php block
*/
?>
<form action="index.php" method = "post">
    
    Customer_Name <input type="text" name = "Customer_name" placeholder="Customer_name" maxlength="15"> <br>
    Customer_address <input type="text" name = "Customer_address" placeholder="Customer_address" maxlength="15"> <br>
    Customer_contact <input type="text" name = "Customer_contact" placeholder="Customer_contact" maxlength="10"> <br>
    Customer_payment <input type="text" name = "Customer_payment" placeholder="customer_payment" maxlength="15"> <br>
    Customer_Credientials <input type="text" name = "Customer_Credientials" placeholder="Customer_Credientials" maxlength="15"> <br>
    <input type="submit" name = "ADD_customer" class="button" VALUE = "ADD_customer"> <br>
    <br>
    <br>
    Updated name <input type ="text" name="cust_name" placeholder="updated_name" maxlength="15"><br>
    Customer_ID <input type ="text" name="cust_ID" placeholder=" Current Customer_ID" maxlength="15"><br>
    <input type="submit" name = "Updated_Customer_Name" class="button" VALUE = "Updated_Customer_Name"> <br>

<table>
        <tr> 
        <h2>Customer_Information</h2>
            <th>Customer_ID</th>
            <th>Customer_name</th>
            <th>Customer_address</th>     
            <th>Customer_contact</th>
            <th>Customer_payment</th>
            <th>Customer_Credietails</th>    
        <tr>
<?php
while ($fullRow = $Selectresult->fetch_array(MYSQLI_ASSOC)) {
    echo '<tr><td>' . $fullRow['Customer_ID'] . '</td>';
    echo '<td>' . $fullRow['Customer_name'] . '</td>';
    echo '<td>' . $fullRow['Customer_address'] . '</td>';
    echo '<td>' . $fullRow['Customer_contact'] . '</td>';
    echo '<td>' . $fullRow['Customer_payment'] . '</td>';
    echo '<td>' . $fullRow['Customer_Credientials'] . '</td><tr>';
}
?>
<table>
        <tr> 
        <h2>Property_Information<h2>
            <th>Property_ID</th>
            <th>Owner_ID</th>
            <th>Property_Name</th>     
            <th>Property_address</th>
            <th>Property_Pricing</th> 
            <th>Property_description</th>
            <th>Bedroom_Count</th>
            <th>Bath_Count</th>
            <th>State</th>
        <tr>
<?php
for($i = 0; $i < $rows; $i++){
                    $fullRow = $Selectresult2->fetch_array(MYSQLI_ASSOC);
                    echo '<tr><td>' . $fullRow['Property_ID'] . '</td>';
                    echo '<td>' . $fullRow['Owner_ID'] . '</td>';
                    echo '<td>' . $fullRow['Property_name'] . '</td>';
                    echo '<td>' . $fullRow['Property_address'] . '</td>';
                    echo '<td>' . $fullRow['Property_pricing'] . '</td>';
                    echo '<td>' . $fullRow['Property_description'] . '</td>';
                    echo '<td>' . $fullRow['Bedroom_Count'] . '</td>';
                    echo '<td>' . $fullRow['Bath_Count'] . '</td>';
                    echo '<td>' . $fullRow['State'] . '</td><tr>';
                }
?>
<table>
        <tr> 
        <h2>property_owner</h2>
            <th>Owner_ID</th>
            <th>Owner_credientials</th>
            <th>Owner_name</th>     
            <th>Owner_address</th>
            <th>Owner_contact</th>
            <th>Owner_financials</th>  
            <th>Owner_permits</th>  
        <tr>
<?php
for($i = 0; $i < $rows; $i++){
                    $fullRow = $Selectresult3->fetch_array(MYSQLI_ASSOC);
                    echo '<tr><td>' . $fullRow['Owner_ID'] . '</td>';
                    echo '<td>' . $fullRow['Owner_credientials'] . '</td>';
                    echo '<td>' . $fullRow['Owner_name'] . '</td>';
                    echo '<td>' . $fullRow['Owner_address'] . '</td>';
                    echo '<td>' . $fullRow['Owner_contact'] . '</td>';
                    echo '<td>' . $fullRow['Owner_financials'] . '</td>';
                    echo '<td>' . $fullRow['Owner_permits'] . '</td><tr>';
                }
                
?>

<table>
        <tr> 
        <h2>Reservation<h2>
            <th>Reservation_ID</th>
            <th>Customer_ID</th>
            <th>Owner_ID</th>     
            <th>Property_ID</th>
            <th>Total_Price</th>
            <th>Dates_reserved</th>
        <tr>

        
        <?php
for($i = 0; $i < $rows; $i++){
                    $fullRow = $Selectresult4->fetch_array(MYSQLI_ASSOC);
                    echo '<tr><td>' . $fullRow['Reservation_ID'] . '</td>';
                    echo '<td>' . $fullRow['Customer_ID'] . '</td>';
                    echo '<td>' . $fullRow['Owner_ID'] . '</td>';
                    echo '<td>' . $fullRow['Property_ID'] . '</td>';
                    echo '<td>' . $fullRow['Total_price'] . '</td>';
                    echo '<td>' . $fullRow['Dates_reserved'] . '</td><tr>';
                }
?>
<form action="index.php" method = "post">
<input type="submit" name = "ADD_Reservation" class="button" VALUE = "ADD_Reservation"> <br>
Customer Credientails <input type="text" name = "Customer_ID" placeholder="Customer_ID" maxlength="15"> <br>
Owner_ID <input type="text" name = "Owner_ID" placeholder="Owner_ID" maxlength="15"> <br>
Property to be reserved <input type="text" name ="Property_ID" placeholder="Property_ID" maxlength="5"><br>
Total Price <input type="text" name = "Total_price" placeholder="Total_price" maxlength="15"> <br>
CREATE Reservation: dd/mm/yyyy-dd/mm/yyyy  <input type="text" name ="Dates_reservered" placeholder="For reservations only" maxlength="20" ><br>

<input type="submit" name = "cancel_reservation" class="button" VALUE = "cancel_reservation"> <br>
cancel trip <input type ="text" name = "res_ID" placeholder="res_ID" maxlength="5"><br>


<table>
            <tr>
                <h2>Recipt as created with IDS<h2>
                    <th>Recipt_ID</th>
                    <th>reservation_ID</th>
                    <th>Property_ID</th>
                    <tr>
<?php
While ($fullRow= $Selectresult5->fetch_array(MYSQLI_ASSOC)){
    echo '<tr><td>' . $fullRow['Recipt_ID'] . '</td>';
    echo '<td>' . $fullRow['Reservation_ID'] . '</td>';
    echo '<td>' . $fullRow['Property_ID'] .  '</td><tr>';
}

?>

<table>
            <tr>
            <h2>Finalized reservation<h2>
            <th>Reservation_ID</th>
            <th>Customer_id</th>
            <th>Owner_name</th>     
            <th>Property_name</th>
            <th>Total_Price</th>
            <th>Dates_reserved</th>
        <tr>
<?php
While ($fullRow= $joinresult->fetch_array(MYSQLI_ASSOC)){
                    echo '<tr><td>' . $fullRow['Reservation_ID'] . '</td>';
                    echo '<td>' . $fullRow['Customer_name'] . '</td>';
                    echo '<td>' . $fullRow['Owner_name'] . '</td>';
                    echo '<td>' . $fullRow['Property_name'] . '</td>';
                    echo '<td>' . $fullRow['Total_price'] . '</td>';
                    echo '<td>' . $fullRow['Dates_reserved'] . '</td><tr>';
}
?>
<table>
            <tr>
                <h2>Finalized recipt<h2>
            <th>Recipt_ID</th>
            <th>Reservation_Date</th>
            <th>Total_Cost</th>
            <th>Property_Name</th>
        <tr>

    <?php
        While ($fullRow= $joinresult2->fetch_array(MYSQLI_ASSOC)){
                    echo '<tr><td>' . $fullRow['Recipt_ID'] . '</td>';
                    echo '<td>' . $fullRow['Dates_reserved'] . '</td>';
                    echo '<td>' . $fullRow['Total_price'] . '</td>';
                    echo '<td>' . $fullRow['Property_name'] . '</td><tr>';
}
?>
<table>
        <tr> 
        <h2>view by State - Texas<h2>
            <th>Property_ID</th>
            <th>Owner_ID</th>
            <th>Property_Name</th>     
            <th>Property_address</th>
            <th>Property_Pricing</th> 
            <th>Property_description</th>
            <th>Bedroom_Count</th>
            <th>Bath_Count</th>
            <th>State</th>
        <tr>

<?php
for($i = 0; $i < $rows; $i++){
                    $fullRow = $resultview1->fetch_array(MYSQLI_ASSOC);
                    echo '<tr><td>' . $fullRow['Property_ID'] . '</td>';
                    echo '<td>' . $fullRow['Owner_ID'] . '</td>';
                    echo '<td>' . $fullRow['Property_name'] . '</td>';
                    echo '<td>' . $fullRow['Property_address'] . '</td>';
                    echo '<td>' . $fullRow['Property_pricing'] . '</td>';
                    echo '<td>' . $fullRow['Property_description'] . '</td>';
                    echo '<td>' . $fullRow['Bedroom_Count'] . '</td>';
                    echo '<td>' . $fullRow['Bath_Count'] . '</td>';
                    echo '<td>' . $fullRow['State'] . '</td><tr>';
                }
?>

    <?php
    
    $conn->close();
    ?>
