
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
          <?php $this->load->view("pro_sidebar")?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
               
            <form action="<?php echo site_url('Sandip1/submit_step/1'); ?>" method="post" enctype="multipart/form-data">
       

            <div class="form-group">
                    <label for="faculty_name"><b>Name of the Faculty</b></label>
                    <input type="text" name="faculty_name" id="faculty_name" placeholder="Name of the Faculty" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="designation"><b>Designation:</b></label>
                    <select name="designation" id="designation" class="form-control">
                        <option value="Professor">Professor</option>
                        <option value="Assistant Professor">Assistant Professor</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="days_present"><b>No. of Days Present:</b></label>
                    <input type="text" name="days_present" id="days_present" placeholder="No. of Days Present" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="lectures_ducked"><b>No. of Lectures Ducked:</b></label>
                    <input type="text" name="lectures_ducked" id="lectures_ducked" placeholder="No. of Lectures Ducked" class="form-control" required>
                </div>






                <div class="container mt-5">
    <h5><b>No. of Research Publications as First Author</b></h5>
    
    <!-- SCI/Scopus/WOS -->
    <div class="form-group">
        <label style="font-size: medium;">SCI/ Scopus/ WOS</label>
        <select id="research_sci" name="sci_option" class="form-control conditional-input" data-target="file_sci">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
        </select>
        <div id="file_sci_count" style="display: none;">
            <label for="sci_count">Select Number of Files (1-10):</label>
            <select id="sci_count" class="form-control" onchange="showFileInputs(this.value, 'file_sci')">
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
            <div id="file_sci" style="display: none;"></div>
        </div>
    </div>

    <!-- UGC -->
    <div class="form-group">
        <label style="font-size: medium;">UGC:</label>
        <select id="research_ugc" name="ugc_option" class="form-control conditional-input" data-target="file_ugc">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
        </select>
        <div id="file_ugc_count" style="display: none;">
            <label for="ugc_count">Select Number of Files (1-10):</label>
            <select id="ugc_count" class="form-control" onchange="showFileInputs(this.value, 'file_ugc')">
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
            <div id="file_ugc" style="display: none;"></div>
        </div>
    </div>

    <!-- Scopus International Conference -->
    <div class="form-group">
        <label style="font-size: medium;">Scopus International Conference:</label>
        <select id="research_scopus" name="international_option" class="form-control conditional-input" data-target="file_scopus">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
        </select>
        <div id="file_scopus_count" style="display: none;">
            <label for="scopus_count">Select Number of Files (1-10):</label>
            <select id="scopus_count" class="form-control" onchange="showFileInputs(this.value, 'file_scopus')">
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
            <div id="file_scopus" style="display: none;"></div>
        </div>
    </div>
</div>





    <h5><b>No. of Research Publications as Second Author</b></h5>
                
    <!--for Second Author SCI/Scopus/WOS  -->
     <div class="form-group">
        <label style="font-size: medium;">SCI/ Scopus/ WOS</label>
        <select id="second_file_sci" name="sec_sci_option" class="form-control conditional-input" data-target="sec_file_sci">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
        </select>
        <div id="sec_file_sci_count" style="display: none;">
            <label for="sci_count_second">Select Number of Files (1-10):</label>
            <select id="sci_count_second" class="form-control" onchange="showFileInputs(this.value, 'sec_file_sci')">
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
            <div id="sec_file_sci" style="display: none;"></div>
        </div>
    </div> 

      <!-- Second Author UGC for --> 
    <div class="form-group">
        <label style="font-size: medium;">UGC:</label>
        <select id="research_ugc_second" name="sec_ugc_option" class="form-control conditional-input" data-target="sec_file_ugc">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
        </select>
        <div id="sec_file_ugc_count" style="display: none;">
            <label for="ugc_count_second">Select Number of Files (1-10):</label>
            <select id="ugc_count_second" class="form-control" onchange="showFileInputs(this.value, 'sec_file_ugc')">
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
            <div id="sec_file_ugc" style="display: none;"></div>
        </div>
    </div> 

    <!--Second Author Scopus International Conference for  -->
    <div class="form-group">
        <label style="font-size: medium;">Scopus International Conference:</label>
        <select id="research_scopus_second" name="sec_international_option" class="form-control conditional-input" data-target="sec_file_scopus">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
        </select>
        <div id="sec_file_scopus_count" style="display: none;">
            <label for="scopus_count_second">Select Number of Files (1-10):</label>
            <select id="scopus_count_second" class="form-control" onchange="showFileInputs(this.value, 'sec_file_scopus')">
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
            <div id="sec_file_scopus" style="display: none;"></div>
        </div>
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