
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
               
            <form action="<?php echo site_url('Sandip1/submit_step/4'); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
    <label for="awards_received"><b>No. of Awards Received:</b></label>
    <select name="awards_received" id="awards_received" class="form-control conditional-input" data-target="file_awards">
        <option value="No">No</option>
        <option value="Yes">Yes</option>
    </select>

    <div id="file_awards_count" style="display: none;">
        <label for="awards_file_count">Select Number of Award Files (1-10):</label>
        <select id="awards_file_count" class="form-control mb-2" onchange="showFileInputs(this.value, 'file_awards')" >
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

        <div id="file_awards" style="display: none;"></div>
    </div>
</div>



                <div class="form-group">
                    <label for="blog_count"><b>No. of Blogs:</b></label>
                    <input type="number" name="blog_count" id="blog_count" placeholder="Number of Blogs" class="form-control">
                </div>




                <div class="form-group">
    <label for="membership_professional_bodies"><b>No. of Memberships of Professional Bodies:</b></label>
    <select name="membership_professional_bodies" id="membership_professional_bodies" class="form-control conditional-input" data-target="file_professional_memberships">
        <option value="No">No</option>
        <option value="Yes">Yes</option>
    </select>

    <div id="file_professional_memberships_count" style="display: none;">
        <label for="membership_file_count">Select Number of Membership Files (1-10):</label>
        <select id="membership_file_count" class="form-control mb-2" onchange="showFileInputs(this.value, 'file_professional_memberships')">
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

        <div id="file_professional_memberships" style="display: none;"></div>
    </div>
</div>


                    <div class="form-group">
                    <label for="vap_session">VAP Session Current:</label>
                    <input type="text" name="vap_session" id="vap_session" placeholder="VAP Session Current" class="form-control">
                </div>
                <div class="form-group">
                    <label for="content_development">Content Development:</label>
                    <input type="text" name="content_development" id="content_development" placeholder="Content Development" class="form-control">
                </div>
                <div class="form-group">
                    <label for="admission_session">Admission Session:</label>
                    <input type="text" name="admission_session" id="admission_session" placeholder="Admission Session" class="form-control">
                </div>
            <!-- </div> -->

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