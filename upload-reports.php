<?php include 'includes/common-header.php' ?>

<div class="container-fluid cms-layout">
    <div class="row h-100">

        <!-- Sidebar -->
        <?php include 'includes/sidebar.php' ?>

        <!-- Main Content -->
        <div class="col content" id="content">
            <!-- Top Navbar -->
            <?php include 'includes/topbar.php' ?>

            <!-- Dashboard Content -->
            <div class="p-2">
                <section class="cms-section py-4">
                    <div class="container">
                        <!-- Upload + Generate -->
                        <form class="row g-3 justify-content-center" method="POST" action="process-upload.php" enctype="multipart/form-data">

                            <div class="col-lg-12">
                                <div class="upload-heading">
                                    <div class="upload-reports">
                                        <img src="assets/icons/upload.png" alt="">
                                    </div>
                                    <h1>Upload Excel Files</h1>
                                    <p>Upload your Excel files containing property data to generate bulk valuation reports. Each file can contain multiple properties for batch processing.</p>
                                </div>
                            </div>

                            <!-- Upload Excel File -->
                            <div class="col-md-5">
                                <div class="p-3 border rounded h-100 uploadfile">
                                    <h5 class="title d-flex align-items-center gap-2">
                                        <img src="assets/icons/upload.png" alt="" width="16">
                                        Upload Excel File
                                    </h5>
                                    <p class="mb-3 text-muted">
                                        Upload your Excel file containing property data to generate bulk valuation reports
                                    </p>

                                    <label for="fileUpload" class="upload-box d-flex flex-column align-items-center justify-content-center text-center p-4">
                                        <img src="assets/icons/report.png" alt="Excel" width="40" class="mb-2">
                                        <strong>Drop your Excel file here</strong>
                                        <span class="text-muted">Supports .xlsx and .xls files up to 10MB</span>

                                        <label for="fileUpload" class="browse-btn mt-3 d-inline-flex align-items-center gap-2">
                                            <img src="assets/icons/upload.png" alt="" width="16">
                                            Browse Files
                                        </label>
                                        <input type="file" id="fileUpload" name="excel" accept=".xlsx,.xls" hidden>
                                    </label>

                                    <!-- Upload Images Zip -->
                                    <label for="imageZip" class="upload-box d-flex flex-column align-items-center justify-content-center text-center p-4 mt-3">
                                        <img src="assets/icons/upload.png" alt="Images" width="40" class="mb-2">
                                        <strong>Drop your Images ZIP here</strong>
                                        <span class="text-muted">Supports .zip files up to 50MB</span>

                                        <label for="imageZip" class="browse-btn mt-3 d-inline-flex align-items-center gap-2">
                                            <img src="assets/icons/upload.png" alt="" width="16">
                                            Browse Files
                                        </label>
                                        <input type="file" id="imageZip" name="images" accept=".zip" hidden>
                                    </label>

                                    <!-- Progress Bar -->
                                    <div class="progress mt-3" style="height: 20px; display: none;" id="progressContainer">
                                        <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                    </div>
                                    <button type="submit" class="btn btn-danger w-100 mt-3">Generate Reports</button>
                                </div>
                            </div>

                            <!-- Upload Guidelines -->
                            <div class="col-md-5">
                                <div class="p-3 border rounded h-100 uploadfile">
                                    <h5 class="title d-flex align-items-center gap-2">
                                        <img src="assets/icons/report.png" alt="" width="16">
                                        Upload Guidelines
                                    </h5>

                                    <div class="guideline-item">
                                        <img src="assets/icons/checkmark.png" alt="" width="20px">
                                        <div>
                                            <strong>Excel Format (.xlsx, .xls)</strong>
                                            <small>Only Excel files are supported</small>
                                        </div>
                                    </div>

                                    <div class="guideline-item">
                                        <img src="assets/icons/checkmark.png" alt="" width="20px">
                                        <div>
                                            <strong>Required Columns</strong>
                                            <small>Address, Property Type, Square Footage</small>
                                        </div>
                                    </div>

                                    <div class="guideline-item">
                                        <img src="assets/icons/checkmark.png" alt="" width="20px">
                                        <div>
                                            <strong>File Size Limit</strong>
                                            <small>Maximum 50MB per file</small>
                                        </div>
                                    </div>

                                    <div class="guideline-item">
                                        <img src="assets/icons/checkmark.png" alt="" width="20px">
                                        <div>
                                            <strong>Images ZIP</strong>
                                            <small>Upload ZIP with images named after the Image column</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/common-footer.php' ?>
