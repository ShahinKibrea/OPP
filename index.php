<?php
include 'database.php';

$obj = new Database();

// $insert_parms =['student_name'=>'shahin kibrea', 'age' => 27, 'city'=>'Goa'];

/*$obj->insert('students', ['student_name'=>'"Milano"', 'age' => 45, 'city'=>'"Norsindi"']);

print_r($obj->getResult());*/

// update 

/*$obj->update('students' ,['age'=>'28'],'city="Bogua"');
echo "Update result is : ";
print_r($obj->getResult());*/

/*$obj->delete('students' ,'city= "Goa"');
echo "Delete result is : ";
print_r($obj->getResult());*/

$obj->select('students', 'id, student_name', null, null, 'student_name', 2);
echo "SQL result is : => ";
print_r($obj->getResult());

?>