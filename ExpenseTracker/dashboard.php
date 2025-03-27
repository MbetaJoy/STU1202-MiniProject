<?php
include('database.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch Name

// Fetch transactions
$sql = "SELECT * FROM transactions WHERE user_id = '$user_id' ORDER BY date DESC";
$result = $connection->query($sql);

$income = 0;
$expense = 0;
$balance = 0; // Initialize balance

$total_sql = "SELECT type, COALESCE(SUM(amount), 0) AS total FROM transactions WHERE user_id = '$user_id' GROUP BY type";
$total_result = $connection->query($total_sql);

while ($row = $total_result->fetch_assoc()) {
    if ($row['type'] == 'income') {
        $income = $row['total'];
    } elseif ($row['type'] == 'expense') {
        $expense = $row['total'];
    }
}

// Ensure balance is always calculated
$balance = $income - $expense;
// Calculate balance after loop
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body{
            background-color:hsl(20, 30, 10);
        }
    </style>
</head>

<body class="container mt-5">
    <div class="row mb-3">
        <div class="col-6 d-flex justify-content-start">
            <h2 class="text-center">Expense Tracker</h2>
        </div>
        <div class="col-6 d-flex justify-content-end">
            <div class="dropdown rounded-circle">
                <button class="btn btn-secondary rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>

    </div>
    <div class="d-flex justify-content-between">
        <h4>Transactions</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal">Add Transaction</button>
    </div>

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Category</th>
                <th>Type</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['date'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td><?= $row['category'] ?></td>
                    <td class="<?= $row['type'] == 'income' ? 'text-success' : 'text-danger' ?>">
                        <?= ucfirst($row['type']) ?>
                    </td>
                    <td>Sh. <?= number_format($row['amount'], 2) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Transaction Modal -->
    <div class="modal fade" id="addTransactionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Add Transaction</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="add_transaction.php" method="POST">
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" name="description" class="form-control" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" name="category" class="form-control" required autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" class="form-control" required autocomplete="off">
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" name="amount" required autocomplete="off">
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Add</button>
                        </div>
                    </form>
                </div>

                <!-- Summary Table -->


            </div>
        </div>
    </div>
    <div class="p-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Total Income</th>
                    <th>Total Expense</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody class="bg-success">
                <tr>
                    <td class="bg-dark text-white"><?= number_format($income, 2) ?></td>
                    <td class="bg-dark text-white"><?= number_format($expense, 2) ?></td>
                    <td class="bg-dark text-white"><?= number_format($balance, 2) ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
