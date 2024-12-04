
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --primary: #0c0c0d;
            --secondary: #1BCF84;
            --accent1: #E25F25;
            --accent2: #6F55F6;
            --accent3: #1BCF84;
            --accent4: #E25F25;
            --accent5: #369FFF;
            --gray: #515A5A;
            --sitebg: #f8f8f8;
            --bgLight: rgba(164, 229, 224, 0.45);
            --softLight: rgba(255, 255, 255, 0.6);
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--sitebg);
        }

        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 4.5rem;
            background-color: #fff;
            border-right: 1px solid #dee2e6;
        }

        .main-content {
            margin-left: 280px;
            padding-top: 4.5rem;
        }

        .nav-link {
            color: var(--primary);
        }

        .nav-link:hover,
        .nav-link:focus {
            background-color: var(--accent1);
            color: #fff;
        }

        .nav-link i {
            color: var(--accent1);
        }

        .nav-link:hover i,
        .nav-link:focus i {
            color: #fff;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    
<?php $this->load->view("pro_navbar")?>
    <div class="container-fluid">
        <div class="row">
          <?php $this->load->view("pro_sidebar")?>>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
               
            <form action="<?php echo site_url('Sandip1/submit_step/2'); ?>" method="post" enctype="multipart/form-data">

       

         
<!-- -------------------2nd part  ---------------------------------->

            
<div class="form-group">
                    <label for="cgp_conducted"><b>No. of CGP Conducted:</b></label>
                    <input type="text" name="cgp_conducted" id="cgp_conducted" placeholder="No. Enter Number" class="form-control" required>
                </div>
              
        <label for="invited_talks"><b>No. of Invited Talks/Lectures Delivered:</b></label>
        <select name="invited_talks" id="invited_talks" class="form-control conditional-input" data-target="file_invited_talks">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
        </select>
        <div id="file_invited_talks_count" style="display: none;">
            <label for="invited_talks_count">Select Number of Files (1-10):</label>
            <select id="invited_talks_count" class="form-control" onchange="showFileInputs(this.value, 'file_invited_talks')">
                <option value="">Select</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
            <div id="file_invited_talks" style="display: none;"></div>
        </div>


        <div class="form-group">
    <label for="fdp_seminars"><b>First No. of FDP Organised</b></label><br>
    <label for="fdp_seminars">First Seminars</label>
    <select name="fdp_seminars" id="fdp_seminars" class="form-control conditional-input" data-target="file_fdp_seminars">
        <option value="No">No</option>
        <option value="Yes">Yes</option>
    </select>
    <div id="file_fdp_seminars_count" style="display: none;">
        <label for="fdp_seminars_count">Select Number of Files (1-10):</label>
        <select id="fdp_seminars_count" class="form-control" onchange="showFileInputs(this.value, 'file_fdp_seminars')">
            <option value="">Select</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
        <div id="file_fdp_seminars" style="display: none;"></div>
    </div>
</div>

<div class="form-group">
    <label for="first_workshop">First Workshops </label>
    <select name="first_workshop" id="first_workshop" class="form-control conditional-input" data-target="file_first_workshop">
        <option value="No">No</option>
        <option value="Yes">Yes</option>
    </select>
    <div id="file_first_workshop_count" style="display: none;">
        <label for="first_workshop_count">Select Number of Files (1-10):</label>
        <select id="first_workshop_count" class="form-control" onchange="showFileInputs(this.value, 'file_first_workshop')">
            <option value="">Select</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
        <div id="file_first_workshop" style="display: none;"></div>
    </div>
</div>

                <br>

                <!-- </div> -->

<!-- <div class="col-md-6"> -->

                <div class="form-group">
    <label for="second_fdp_seminars"><b> Second No. of FDP Organised</b></label><br>
    <label for="second_fdp_seminars">Second Seminars</label>
    <select name="second_fdp_seminars" id="second_fdp_seminars" class="form-control conditional-input" data-target="second_file_fdp_seminars">
        <option value="No">No</option>
        <option value="Yes">Yes</option>
    </select>
    <div id="second_file_fdp_seminars_count" style="display: none;">
        <label for="second_fdp_seminars_count">Select Number of Files (1-10):</label>
        <select id="second_fdp_seminars_count" class="form-control" onchange="showFileInputs(this.value, 'second_file_fdp_seminars')">
            <option value="">Select</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
        <div id="second_file_fdp_seminars" style="display: none;"></div>
    </div>
</div>





<div class="form-group">
 
    <label for="second_workshops">Second Workshops</label>
    <select name="second_workshops" id="second_workshops" class="form-control conditional-input" data-target="second_file_workshops">
        <option value="No">No</option>
        <option value="Yes">Yes</option>
    </select>
    <div id="second_file_workshops_count" style="display: none;">
        <label for="second_workshops_count">Select Number of Files (1-10):</label>
        <select id="second_workshops_count" class="form-control" onchange="showFileInputs(this.value, 'second_file_workshops')">
            <option value="">Select</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
        <div id="second_file_workshops" style="display: none;"></div>
    </div>
</div>





<div class="form-group">

    <label for="second_conference">Second Conferences</label>
    <select name="second_conference" id="second_conference" class="form-control conditional-input" data-target="second_file_conference">
        <option value="No">No</option>
        <option value="Yes">Yes</option>
    </select>
    <div id="second_file_conference_count" style="display: none;">
        <label for="second_conference_count">Select Number of Files (1-10):</label>
        <select id="second_conference_count" class="form-control" onchange="showFileInputs(this.value, 'second_file_conference')">
            <option value="">Select</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
        <div id="second_file_conference" style="display: none;"></div>
    </div>
</div>



                <div class="form-group">
                    <label for="industries_placement"><b>No. of Industries Brought for Placement:<b></label>
                    <input type="number" name="industries_placement" id="industries_placement" placeholder="Enter Number of Industries" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="students_placed"><b>No. of Students Placed:<b></label>
                    <input type="number" name="students_placed" id="students_placed" placeholder="Enter Number of Students Placed" class="form-control" required>
                </div>



        <input type="submit" value="Next">
    </form>
                
            </main>
        </div>
    </div>

    <script>
// Function to display file input fields dynamically based on user selection
function showFileInputs(num, targetId) {
    const fileInputDiv = document.getElementById(targetId);
    fileInputDiv.innerHTML = ''; // Clear previous inputs

    if (num > 0) {
        fileInputDiv.style.display = 'block'; // Show the input area
        for (let i = 1; i <= num; i++) {
            const input = document.createElement('input');
            input.type = 'file';
            input.name = `${targetId}_file_${i}`; // Use template literals for better readability
            input.className = 'form-control mb-2'; // Add some margin
            fileInputDiv.appendChild(input);
        }
    } else {
        fileInputDiv.style.display = 'none'; // Hide the input area
    }
}

// Show/hide additional fields based on dropdown change
document.querySelectorAll('.conditional-input').forEach(select => {
    select.addEventListener('change', function() {
        const targetId = this.getAttribute('data-target'); // Get the target field
        const targetDivCount = document.getElementById(`${targetId}_count`);
        const fileInputDiv = document.getElementById(targetId);

        // Show or hide the file count section
        if (this.value === 'Yes') {
            targetDivCount.style.display = 'block';
        } else {
            targetDivCount.style.display = 'none';
            fileInputDiv.style.display = 'none';
            fileInputDiv.innerHTML = ''; // Clear any file inputs
        }
    });
});

</script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Script -->
    <script>
document.addEventListener('DOMContentLoaded', function () {
    var sidebar = document.getElementById('sidebarMenuMobile');
    var toggler = document.querySelector('.navbar-toggler');

    toggler.addEventListener('click', function () {
        if (sidebar.style.left === '0px') {
            sidebar.style.left = '-250px'; // Adjust according to your sidebar width
        } else {
            sidebar.style.left = '0px';
        }
    });
});
</script>

</body>

</html>