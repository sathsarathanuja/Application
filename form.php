<?php
@include 'config.php';

if (isset($_POST['add_product'])) {
    $refID = $_POST['refID'];
    $Register_Date  = $_POST['regdate'];
    $Exam_Date   = $_POST['exdate'];
    $branch = $_POST['branch'];
    $course = $_POST['course'];
    $title = $_POST['title'];
    $fullname = $_POST['fullname'];
    $nwi = $_POST['nwi'];
    $NIC  = $_POST['NIC'];
    $dob  = $_POST['dob'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $civilStatus = isset($_POST['civilStatus']) ? $_POST['civilStatus'] : '';
    $CA = $_POST['CA'];
    $AL2 = $_POST['AL2'];
    $AL3 = $_POST['AL3'];
    $mobileno = $_POST['mobileno'];
    $whatsappno = $_POST['whatsappno'];
    $rno = $_POST['rno'];
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : '';
    $course = $_POST['course'];
    $firstTime = isset($_POST['firstTime']) ? $_POST['firstTime'] : '';
    $certify = isset($_POST['certify']) ? 'Yes' : 'No';
    $selectedSubjects = isset($_POST['subjects']) ? $_POST['subjects'] : array();


    // Check if the email address is valid
    if (!$email) {
        $message[] = 'Please enter a valid email address.';
        $message[] = 'Email validation failed: ' . filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    }

    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/' . $product_image;

    $nic_image = $_FILES['nic_image']['name'];
    $nic_image_tmp_name = $_FILES['nic_image']['tmp_name'];
    $nic_image_folder = 'uploaded_img/' . $nic_image;

    $nicr_image = $_FILES['nicr_image']['name'];
    $nicr_image_tmp_name = $_FILES['nicr_image']['tmp_name'];
    $nicr_image_folder = 'uploaded_img/' . $nicr_image;

    if (
        empty($Register_Date) || empty($Exam_Date) || empty($branch) || empty($title) || empty($nwi)  || empty($NIC)
        || empty($dob) || empty($gender)  || empty($civilStatus) || empty($CA) || empty($AL2) || empty($AL3) || empty($mobileno) ||
        empty($whatsappno) || empty($rno) || empty($email) || empty($product_image)  || empty($nic_image) || empty($nicr_image) || empty($firstTime)  || empty($selectedSubjects)
    ) {
        $message[] = 'Please fill out all fields.';
    } else {
        $tableName = '';

        switch ($branch) {
            case 'MUL':
                $tableName = 'mulleria';
                break;
            case 'GMP':
                $tableName = 'gampaha';
                break;

                // Add more cases for other branches as needed
            default:
                // Default table name if none of the cases match
                $tableName = 'default_table';
        }

        $insert = "INSERT INTO $tableName (refID, regdate, exdate, branch, title, fullname, nwi, NIC, dob, gender, civilstatus, CA, AL2, AL3, mobileno, whatsappno, rno, email, course, image, NICf, NICr, firstTime, certify,failsubjects) 
VALUES ('$refID', '$Register_Date', '$Exam_Date', '$branch', '$title', '$fullname', '$nwi', '$NIC', '$dob', '$gender', '$civilStatus', '$CA', '$AL2', '$AL3', '$mobileno', '$whatsappno', '$rno', '$email', '$course', '$product_image', '$nic_image', '$nicr_image', '$firstTime', '$certify', '" . implode(',', $selectedSubjects) . "')
";



        $upload = mysqli_query($conn, $insert);

        if ($upload) {
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            move_uploaded_file($nic_image_tmp_name, $nic_image_folder);
            move_uploaded_file($nicr_image_tmp_name, $nicr_image_folder);
            $message[] = 'New Application added successfully.';
        } else {
            $message[] = 'Could not add the Application.';
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/form.css">
</head>

<body>

    <?php

    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<span class="message">' . $msg . '</span>';
        }
    }

    ?>

    <div class="container">
        <div class="admin-product-form-container">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <h3>Apply Exam</h3>

                <label for="refID">Reference ID:</label>
                <input type="text" placeholder="Enter" name="refID" id="refID" class="box">

                <label for="Register_Date">Register Date :</label>
                <input type="Date" placeholder="Enter" name="regdate" id="Register_Date" class="box">

                <label for="Exam_Date">Exam Date :</label>
                <input type="Date" placeholder="Enter" name="exdate" id="Exam_Date" class="box">


                <label for="branch">Branch Code:</label>
                <select name="branch" id="branch" class="box">

                    <option value="MUL">MUL</option>
                    <option value="BDW">BDW</option>
                    <option value="DMG">DMG</option>
                    <option value="GMP">GMP</option>
                    <option value="HTN">HTN</option>
                    <option value="HDQ">HDQ</option>
                    <option value="KDU">KDU</option>
                    <option value="KLT">KLT</option>
                    <option value="KDY">KDY</option>
                    <option value="KEG">KEG</option>
                    <option value="KBG">KBG</option>
                    <option value="KTM">KTM</option>
                    <option value="KUG">KUG</option>
                    <option value="MHG">MHG</option>
                    <option value="NGO">NGO</option>
                    <option value="NTB">NTB</option>
                    <option value="PER">PER</option>
                    <option value="PLN">PLN</option>
                    <option value="RTP">RTP</option>
                    <!-- Add more options as needed -->
                </select>

                <label for="title">Title:</label>
                <select name="title" id="title" class="box">
                    <option value="Rev">Rev</option>
                    <option value="Ms">Ms</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Mr">Mr</option>
                    <!-- Add more options as needed -->
                </select>

                <label for="fullname">Full Name:(The certificate will be issuid as per full name )</label>
                <input type="text" placeholder="Enter" name="fullname" id="fullname" class="box">

                <label for="nwi">Name with Initials :</label>
                <input type="text" placeholder="Enter" name="nwi" id="nwi" class="box">

                <label for="nwi">Your NIC Number :</label>
                <input type="text" placeholder="Enter" name="NIC" id="NIC" class="box">

                <label for="dob">Date of Birth :</label>
                <input type="Date" placeholder="Enter" name="dob" id="dob" class="box">

                <label for="gender">Gender:</label>
                <input type="radio" name="gender" value="Male" id="male" class="box">
                <label for="male">Male</label>
                <input type="radio" name="gender" value="Female" id="female" class="box">
                <label for="female">Female</label>

                <label for="civilStatus">Civil Status:</label>
                <input type="radio" name="civilStatus" value="Single" id="single" class="box">
                <label for="single">Single</label>
                <input type="radio" name="civilStatus" value="Married" id="married" class="box">
                <label for="married">Married</label>

                <label for="CA">Correspondence Address (Mailing) :</label>
                <input type="text" placeholder="Enter" name="CA" id="CA" class="box">

                <label for="AL2">Address Line 2 :</label>
                <input type="text" placeholder="Enter" name="AL2" id="AL2" class="box">

                <label for="AL3">Address Line 3 :</label>
                <input type="text" placeholder="Enter" name="AL3" id="AL3" class="box">

                <label for="mobileno">Mobile Number :</label>
                <input type="text" placeholder="Enter" name="mobileno" id="mobileno" class="box">

                <label for="whatsappno">whatsapp Number :</label>
                <input type="text" placeholder="Enter" name="whatsappno" id="whatsappno" class="box">

                <label for="rno">Residence Number :</label>
                <input type="text" placeholder="Enter" name="rno" id="rno" class="box">

                <label for="email">Email Address:</label>
                <input type="email" placeholder="Enter" name="email" id="email" class="box">

                <label for="course">Select Course:</label>
                <select name="course" id="course" class="box">
                    <option value="Course 1">Course 1</option>
                    <option value="Course 2">Course 2</option>
                    <option value="Course 3">Course 3</option>
                    <!-- Add more options as needed -->
                </select>


                <label for="product_image">Your Image:<br>( මෙම ඡායාරූපය ඔබගේ සහතිකයේ මුද්‍රණය කරණු ලැබේ. )</label>
                <label for="product_image"><br>

                    1. චායාරූපය පාස්පොට් ප්‍රමාණය විය යුතුය.<br><br>

                    2. ඔබ අපට යොමු කරන චායාරූපය මැතකදී ලබගත් සහ වර්ණවත් සහ පසුබිම නිල් පැහැති විය යුතුය.<br><br>

                    3. KIDS Courses සදහා වන චායාරූපය පාසල් නිල ඇදුමින් සමන්විත විය යුතුය.<br><br>

                    4. අනෙකුත් සියලුම පාඨමාලා සදහා පිරිමි ලමුන් ඔනැම වර්ණයකින් යුත් Shirt එකක් සහ ටයි පටිය සහ Coat එක පැලදි චායාරූපයක් විය යුතුය. / ගහැණු ලමුන් සදහා ඔනෑම වර්ණයකින් යුත් Blouse එකක් සහ Coat එකක් පැලදි චායාරූපයක් විය යුතුයි.:</label>
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" id="product_image" class="box">

                <label for="nic_image">NIC Image [Font]: <br><br>** අවු.16 ට වැඩි සිසුන් ජාතික හැදුනුම්පත් ඇතුලත් කරන්න / අවු.16 ට අඩු සිසුන් උප්පැන්න සහතිකය ඇතුලත් කරන්න.</label>

                <input type="file" accept="image/png, image/jpeg, image/jpg" name="nic_image" id="nic_image" class="box">

                <label for="nicr_image">NIC Image [rear]:</label>
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="nicr_image" id="nicr_image" class="box">

                <label for="firstTime">Is it the first time appearing in the exam?</label>
                <input type="radio" name="firstTime" value="Yes" id="yes" class="box">
                <label for="yes">Yes</label>
                <input type="radio" name="firstTime" value="No" id="no" class="box">
                <label for="no">No</label>

                <div id="courseSubjects" style="display:none;">
                    <!-- Course 1 Subjects -->
                    <div id="course1Subjects">
                        <label for="subject1">AAA</label>
                        <input type="checkbox" name="subjects[]" value="Subject 1" id="subject1" class="box">

                        <label for="subject2">AAAA</label>
                        <input type="checkbox" name="subjects[]" value="Subject 2" id="subject2" class="box">

                        <!-- Add more subjects for Course 1 as needed -->
                    </div>

                    <!-- Course 2 Subjects -->
                    <div id="course2Subjects" style="display:none;">
                        <label for="subject3">BBBBBB</label>
                        <input type="checkbox" name="subjects[]" value="Subject 3" id="subject3" class="box">

                        <label for="subject4">BBBBB</label>
                        <input type="checkbox" name="subjects[]" value="Subject 4" id="subject4" class="box">

                        <!-- Add more subjects for Course 2 as needed -->
                    </div>

                    <!-- Course 3 Subjects -->
                    <div id="course3Subjects" style="display:none;">
                        <label for="subject5">CCC</label>
                        <input type="checkbox" name="subjects[]" value="Subject 5" id="subject5" class="box">

                        <label for="subject6">CCC</label>
                        <input type="checkbox" name="subjects[]" value="Subject 6" id="subject6" class="box">

                        <!-- Add more subjects for Course 3 as needed -->
                    </div>
                </div>

                <label for="certify">I hereby certify that the above particulars are true and correct?</label>
                <input type="checkbox" name="certify" id="certify" class="box">





                <input type="submit" class="btn" name="add_product" value="Submit">
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the elements
            var courseSelect = document.getElementById("course");
            var firstTimeNo = document.getElementById("no");
            var courseSubjectsContainer = document.getElementById("courseSubjects");
            var course1Subjects = document.getElementById("course1Subjects");
            var course2Subjects = document.getElementById("course2Subjects");
            var course3Subjects = document.getElementById("course3Subjects");

            // Add event listeners to the course and firstTime radio buttons
            courseSelect.addEventListener("change", updateSubjectsVisibility);
            firstTimeNo.addEventListener("change", updateSubjectsVisibility);

            // Function to update the visibility of the subjects based on selections
            function updateSubjectsVisibility() {
                // Hide all course subjects initially
                course1Subjects.style.display = "none";
                course2Subjects.style.display = "none";
                course3Subjects.style.display = "none";

                // Check if the selected course is "Course 1," "Course 2," or "Course 3" and the "No" radio button is selected
                if (courseSelect.value === "Course 1" && firstTimeNo.checked) {
                    course1Subjects.style.display = "block";
                } else if (courseSelect.value === "Course 2" && firstTimeNo.checked) {
                    course2Subjects.style.display = "block";
                } else if (courseSelect.value === "Course 3" && firstTimeNo.checked) {
                    course3Subjects.style.display = "block";
                }

                // Show or hide the subjects container based on the conditions
                if ((courseSelect.value === "Course 1" || courseSelect.value === "Course 2" || courseSelect.value === "Course 3") && firstTimeNo.checked) {
                    courseSubjectsContainer.style.display = "block";
                } else {
                    courseSubjectsContainer.style.display = "none";
                }
            }
        });
    </script>


</body>

</html>