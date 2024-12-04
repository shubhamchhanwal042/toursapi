
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
                <form action="<?php echo site_url('Sandip1/submit_step/3'); ?>" method="post" enctype="multipart/form-data">
                    <!-- ------------------------------------3rd steps -------------------------- -->
                    <div class="form-group">
                        <label for="consultancy_received"><b>Consultancy Received (Amount):</b></label>
                        <select name="consultancy_received" id="consultancy_received" class="form-control conditional-input" data-target="consultancy_received_files">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>

                        <div id="consultancy_received_files_count" style="display: none;">
                            <label for="consultancy_amount">Enter Amount:</label>
                            <input type="number" name="consultancy_amount" id="consultancy_amount" placeholder="Enter Amount" class="form-control mb-2">
                            
                            <label for="consultancy_file_count">Select Number of Receipt Files (1-10):</label>
                            <select id="consultancy_file_count" class="form-control mb-2" onchange="showFileInputs(this.value, 'consultancy_received_files')">
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

                            <div id="consultancy_received_files" style="display: none;"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="grant_received"><b>Research/Other Grant Received (Amount):</b></label>
                        <select name="grant_received" id="grant_received" class="form-control conditional-input" data-target="grant_received_files">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>

                        <div id="grant_received_files_count" style="display: none;">
                            <label for="grant_amount">Enter Amount:</label>
                            <input type="number" name="grant_amount" id="grant_amount" placeholder="Enter Amount" class="form-control mb-2" >
                            
                            <label for="grant_file_count">Select Number of Receipt Files (1-10):</label>
                            <select id="grant_file_count" class="form-control mb-2" onchange="showFileInputs(this.value, 'grant_received_files')">
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

                            <div id="grant_received_files" style="display: none;"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="mou"><b>No. of MoU:</b></label>
                        <select name="mou" id="mou" class="form-control conditional-input" data-target="file_mou">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>

                        <div id="file_mou_count" style="display: none;">
                            <label for="mou_file_count">Select Number of MoU Files (1-10):</label>
                            <select id="mou_file_count" class="form-control mb-2" onchange="showFileInputs(this.value, 'file_mou')">
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

                            <div id="file_mou" style="display: none;"></div>
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
