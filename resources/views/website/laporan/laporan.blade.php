<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .card {
            margin-bottom: 30px;
        }

        @media (min-width: 992px) {
            .card {
                margin-left: 20px;
            }
        }

        .btn-box {
            border-radius: 11px;
            padding: 10px 20px;
            width: 80px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            margin-left: 50px;
        }

        .btn-box:hover {
            background-color: #0056b3;
        }

        .btn-box + .btn-box {
            margin-left: 20px;
        }

        .form-control-lg {
            padding: 15px 20px;
        }

        .col-lg-4 {
            flex: 0 0 auto;
            width: 50%;
        }
    </style>
</head>
<body>
    <br>
    <br>
    <main id="main" class="main">
        <div class="container">
            <div class="row">
                <!-- Print Form -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Print</h5>
                            <form action="{{ url('print') }}" method="post" target="_blank">
                            @csrf
                                <div class="mb-3 mt-3">
                                    <label for="printMonth" class="formal-label">Bulan</label>
                                    <div class="row mb-3">
                                    <input type="date" class="form-control"  name="MONTH">
                                    
                                    </div>
                                </div>
                                <div class="mb-3 mt-3">
                                    <label for="printYear" class="formal-label">Tahun</label>
                                    <div class="row mb-3">
                                    <input type="date" class="form-control"  name="YEAR">
                                    
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary btn-sm btn-box">Print</button>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" formaction="{{ url('pdf1') }}" class="btn btn-primary btn-sm btn-box">PDF</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>