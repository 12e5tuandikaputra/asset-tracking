<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>💰 Dashboard Keuangan Personal - Monthly Budgeting</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 20px;
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        text-align: center;
    }

    .header h1 {
        font-size: 2.5em;
        margin-bottom: 10px;
    }

    .main-content {
        padding: 30px;
    }

    .tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        border-bottom: 2px solid #e2e8f0;
        flex-wrap: wrap;
    }

    .tab {
        padding: 15px 30px;
        border: none;
        background: transparent;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        color: #64748b;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
    }

    .tab:hover {
        color: #667eea;
    }

    .tab.active {
        color: #667eea;
        border-bottom-color: #667eea;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .controls {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-warning {
        background: #f59e0b;
        color: white;
    }

    .dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .card {
        background: #f8fafc;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card h2 {
        color: #1e293b;
        margin-bottom: 20px;
        font-size: 1.5em;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }

    .summary-item {
        background: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        border-left: 4px solid #667eea;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .summary-item.positive {
        border-left-color: #10b981;
    }

    .summary-item.negative {
        border-left-color: #ef4444;
    }

    .summary-item.warning {
        border-left-color: #f59e0b;
    }

    .summary-item h3 {
        color: #64748b;
        font-size: 0.9em;
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    .summary-item p {
        color: #1e293b;
        font-size: 1.8em;
        font-weight: bold;
    }

    .form-section {
        background: #f8fafc;
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #1e293b;
        font-weight: 600;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 16px;
        transition: border 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
    }

    .budget-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .budget-table th {
        background: #667eea;
        color: white;
        padding: 15px;
        text-align: left;
        font-weight: 600;
    }

    .budget-table td {
        padding: 15px;
        border-bottom: 1px solid #e2e8f0;
    }

    .budget-table tr:hover {
        background: #f8fafc;
    }

    .progress-bar {
        width: 100%;
        height: 30px;
        background: #e2e8f0;
        border-radius: 15px;
        overflow: hidden;
        position: relative;
    }

    .progress-fill {
        height: 100%;
        transition: width 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 0.9em;
    }

    .progress-fill.good {
        background: linear-gradient(90deg, #10b981, #059669);
    }

    .progress-fill.warning {
        background: linear-gradient(90deg, #f59e0b, #d97706);
    }

    .progress-fill.danger {
        background: linear-gradient(90deg, #ef4444, #dc2626);
    }

    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 600;
    }

    .badge-income {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-expense {
        background: #fee2e2;
        color: #991b1b;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        border-left: 4px solid;
    }

    .alert-success {
        background: #d1fae5;
        border-left-color: #10b981;
        color: #065f46;
    }

    .alert-warning {
        background: #fef3c7;
        border-left-color: #f59e0b;
        color: #92400e;
    }

    .alert-danger {
        background: #fee2e2;
        border-left-color: #ef4444;
        color: #991b1b;
    }

    .alert-info {
        background: #dbeafe;
        border-left-color: #3b82f6;
        color: #1e40af;
    }

    .month-selector {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        background: white;
        padding: 15px;
        border-radius: 10px;
    }

    .month-selector input,
    .month-selector select {
        padding: 10px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 16px;
    }

    .chart-container {
        position: relative;
        height: 350px;
    }

    .budget-category-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .budget-category-card h4 {
        color: #1e293b;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .category-icon {
        font-size: 1.5em;
        margin-right: 10px;
    }

    .budget-input-group {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 10px;
        align-items: end;
    }

    .net-worth-banner {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 40px;
        border-radius: 15px;
        text-align: center;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
    }

    .net-worth-banner h2 {
        font-size: 1.5em;
        margin-bottom: 15px;
        opacity: 0.9;
    }

    .net-worth-banner .amount {
        font-size: 3.5em;
        font-weight: bold;
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .dashboard {
            grid-template-columns: 1fr;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .budget-input-group {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>💰 Dashboard Keuangan Personal</h1>
            <p>Kelola Keuangan, Budget & Transaksi Anda dengan Mudah</p>
        </div>

        <div class="main-content">
            <div class="tabs">
                <button class="tab active" onclick="switchTab('dashboard')">🏠 Dashboard</button>
                <button class="tab" onclick="switchTab('budget')">🎯 Monthly Budget</button>
                <button class="tab" onclick="switchTab('transactions')">💳 Transaksi</button>
                <button class="tab" onclick="switchTab('assets')">🏦 Aset & Liabilitas</button>
                <button class="tab" onclick="switchTab('settings')">⚙️ Pengaturan</button>
            </div>

            <!-- TAB DASHBOARD -->
            <div id="dashboard" class="tab-content active">
                <div class="net-worth-banner">
                    <h2>💎 Total Kekayaan Bersih (Net Worth)</h2>
                    <div class="amount" id="netWorth">Rp 0</div>
                    <div class="subtitle">Total Aset - Total Liabilitas</div>
                </div>

                <div class="month-selector">
                    <label><strong>Pilih Bulan untuk Cashflow:</strong></label>
                    <input type="month" id="dashboardMonth" onchange="updateDashboard()">
                </div>

                <div class="summary-grid">
                    <div class="summary-item positive">
                        <h3>💰 Total Aset</h3>
                        <p id="dashTotalAssets">Rp 0</p>
                    </div>
                    <div class="summary-item negative">
                        <h3>📉 Total Liabilitas</h3>
                        <p id="dashTotalLiabilities">Rp 0</p>
                    </div>
                    <div class="summary-item positive">
                        <h3>📈 Pemasukan</h3>
                        <p id="dashIncome">Rp 0</p>
                    </div>
                    <div class="summary-item negative">
                        <h3>📊 Pengeluaran</h3>
                        <p id="dashExpense">Rp 0</p>
                    </div>
                    <div class="summary-item">
                        <h3>💵 Saldo Bulanan</h3>
                        <p id="dashBalance">Rp 0</p>
                    </div>
                    <div class="summary-item warning">
                        <h3>🎯 Budget Usage</h3>
                        <p id="dashBudgetUsage">0%</p>
                    </div>
                </div>

                <div class="dashboard">
                    <div class="card">
                        <h2>📊 Pengeluaran by Kategori</h2>
                        <div class="chart-container">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>

                    <div class="card">
                        <h2>📈 Budget vs Actual</h2>
                        <div class="chart-container">
                            <canvas id="budgetChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB MONTHLY BUDGET -->
            <div id="budget" class="tab-content">
                <h2 style="color: #1e293b; margin-bottom: 20px;">🎯 Monthly Budget Planner</h2>

                <div class="alert alert-info">
                    <strong>💡 Tips:</strong> Set budget untuk setiap kategori pengeluaran. Sistem akan tracking
                    otomatis dan memberi alert jika mendekati limit!
                </div>

                <div class="month-selector">
                    <label><strong>Pilih Bulan Budget:</strong></label>
                    <select id="budgetMonthSelect" onchange="loadBudgetForMonth()"></select>
                    <button class="btn btn-warning" onclick="copyPreviousBudget()">📋 Copy Budget Bulan Lalu</button>
                    <button class="btn btn-success" onclick="autoSuggestBudget()">💡 Auto Suggest</button>
                </div>

                <div id="budgetAlerts"></div>

                <div class="summary-grid">
                    <div class="summary-item">
                        <h3>💰 Total Budget</h3>
                        <p id="totalBudget">Rp 0</p>
                    </div>
                    <div class="summary-item negative">
                        <h3>💸 Total Pengeluaran</h3>
                        <p id="totalSpent">Rp 0</p>
                    </div>
                    <div class="summary-item positive">
                        <h3>💵 Sisa Budget</h3>
                        <p id="remainingBudget">Rp 0</p>
                    </div>
                    <div class="summary-item warning">
                        <h3>📊 Persentase Terpakai</h3>
                        <p id="budgetPercentage">0%</p>
                    </div>
                </div>

                <div class="card">
                    <h2>📝 Set Budget per Kategori</h2>

                    <div class="form-section">
                        <h3 style="color: #667eea; margin-bottom: 20px;">🛒 Kebutuhan Pokok</h3>

                        <div class="budget-category-card">
                            <div class="budget-input-group">
                                <div class="form-group" style="margin: 0;">
                                    <label>🍽️ Makanan & Minuman</label>
                                    <input type="number" class="budget-input" data-category="Makanan"
                                        placeholder="Budget (Rp)" min="0">
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <label>Pengeluaran Aktual</label>
                                    <input type="text" class="actual-display" data-category="Makanan" readonly>
                                </div>
                                <button class="btn btn-primary" onclick="saveCategoryBudget('Makanan')">💾
                                    Simpan</button>
                            </div>
                            <div class="progress-bar" style="margin-top: 15px;">
                                <div class="progress-fill good" id="progress-Makanan" style="width: 0%">0%</div>
                            </div>
                        </div>

                        <div class="budget-category-card">
                            <div class="budget-input-group">
                                <div class="form-group" style="margin: 0;">
                                    <label>🛒 Belanja Kebutuhan</label>
                                    <input type="number" class="budget-input" data-category="Belanja"
                                        placeholder="Budget (Rp)" min="0">
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <label>Pengeluaran Aktual</label>
                                    <input type="text" class="actual-display" data-category="Belanja" readonly>
                                </div>
                                <button class="btn btn-primary" onclick="saveCategoryBudget('Belanja')">💾
                                    Simpan</button>
                            </div>
                            <div class="progress-bar" style="margin-top: 15px;">
                                <div class="progress-fill good" id="progress-Belanja" style="width: 0%">0%</div>
                            </div>
                        </div>

                        <div class="budget-category-card">
                            <div class="budget-input-group">
                                <div class="form-group" style="margin: 0;">
                                    <label>🚗 Transport</label>
                                    <input type="number" class="budget-input" data-category="Transport"
                                        placeholder="Budget (Rp)" min="0">
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <label>Pengeluaran Aktual</label>
                                    <input type="text" class="actual-display" data-category="Transport" readonly>
                                </div>
                                <button class="btn btn-primary" onclick="saveCategoryBudget('Transport')">💾
                                    Simpan</button>
                            </div>
                            <div class="progress-bar" style="margin-top: 15px;">
                                <div class="progress-fill good" id="progress-Transport" style="width: 0%">0%</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 style="color: #667eea; margin-bottom: 20px;">💡 Tagihan Rutin</h3>

                        <div class="budget-category-card">
                            <div class="budget-input-group">
                                <div class="form-group" style="margin: 0;">
                                    <label>⚡ Listrik, Air, Gas</label>
                                    <input type="number" class="budget-input" data-category="Tagihan"
                                        placeholder="Budget (Rp)" min="0">
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <label>Pengeluaran Aktual</label>
                                    <input type="text" class="actual-display" data-category="Tagihan" readonly>
                                </div>
                                <button class="btn btn-primary" onclick="saveCategoryBudget('Tagihan')">💾
                                    Simpan</button>
                            </div>
                            <div class="progress-bar" style="margin-top: 15px;">
                                <div class="progress-fill good" id="progress-Tagihan" style="width: 0%">0%</div>
                            </div>
                        </div>

                        <div class="budget-category-card">
                            <div class="budget-input-group">
                                <div class="form-group" style="margin: 0;">
                                    <label>Monthly Housing Cost</label>
                                    <input type="number" class="budget-input" data-category="Tagihan"
                                        placeholder="Budget (Rp)" min="0">
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <label>Pengeluaran Aktual</label>
                                    <input type="text" class="actual-display" data-category="Tagihan" readonly>
                                </div>
                                <button class="btn btn-primary" onclick="saveCategoryBudget('Tagihan')">💾
                                    Simpan</button>
                            </div>
                            <div class="progress-bar" style="margin-top: 15px;">
                                <div class="progress-fill good" id="progress-Tagihan" style="width: 0%">0%</div>
                            </div>
                        </div>

                        <div class="budget-category-card">
                            <div class="budget-input-group">
                                <div class="form-group" style="margin: 0;">
                                    <label>💳 Cicilan & Pinjaman</label>
                                    <input type="number" class="budget-input" data-category="Cicilan"
                                        placeholder="Budget (Rp)" min="0">
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <label>Pengeluaran Aktual</label>
                                    <input type="text" class="actual-display" data-category="Cicilan" readonly>
                                </div>
                                <button class="btn btn-primary" onclick="saveCategoryBudget('Cicilan')">💾
                                    Simpan</button>
                            </div>
                            <div class="progress-bar" style="margin-top: 15px;">
                                <div class="progress-fill good" id="progress-Cicilan" style="width: 0%">0%</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 style="color: #667eea; margin-bottom: 20px;">🎉 Lifestyle & Lainnya</h3>

                        <div class="budget-category-card">
                            <div class="budget-input-group">
                                <div class="form-group" style="margin: 0;">
                                    <label>🎮 Hiburan</label>
                                    <input type="number" class="budget-input" data-category="Hiburan"
                                        placeholder="Budget (Rp)" min="0">
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <label>Pengeluaran Aktual</label>
                                    <input type="text" class="actual-display" data-category="Hiburan" readonly>
                                </div>
                                <button class="btn btn-primary" onclick="saveCategoryBudget('Hiburan')">💾
                                    Simpan</button>
                            </div>
                            <div class="progress-bar" style="margin-top: 15px;">
                                <div class="progress-fill good" id="progress-Hiburan" style="width: 0%">0%</div>
                            </div>
                        </div>

                        <div class="budget-category-card">
                            <div class="budget-input-group">
                                <div class="form-group" style="margin: 0;">
                                    <label>🏥 Kesehatan</label>
                                    <input type="number" class="budget-input" data-category="Kesehatan"
                                        placeholder="Budget (Rp)" min="0">
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <label>Pengeluaran Aktual</label>
                                    <input type="text" class="actual-display" data-category="Kesehatan" readonly>
                                </div>
                                <button class="btn btn-primary" onclick="saveCategoryBudget('Kesehatan')">💾
                                    Simpan</button>
                            </div>
                            <div class="progress-bar" style="margin-top: 15px;">
                                <div class="progress-fill good" id="progress-Kesehatan" style="width: 0%">0%</div>
                            </div>
                        </div>

                        <div class="budget-category-card">
                            <div class="budget-input-group">
                                <div class="form-group" style="margin: 0;">
                                    <label>📚 Pendidikan</label>
                                    <input type="number" class="budget-input" data-category="Pendidikan"
                                        placeholder="Budget (Rp)" min="0">
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <label>Pengeluaran Aktual</label>
                                    <input type="text" class="actual-display" data-category="Pendidikan" readonly>
                                </div>
                                <button class="btn btn-primary" onclick="saveCategoryBudget('Pendidikan')">💾
                                    Simpan</button>
                            </div>
                            <div class="progress-bar" style="margin-top: 15px;">
                                <div class="progress-fill good" id="progress-Pendidikan" style="width: 0%">0%</div>
                            </div>
                        </div>

                        <div class="budget-category-card">
                            <div class="budget-input-group">
                                <div class="form-group" style="margin: 0;">
                                    <label>🎯 Lainnya</label>
                                    <input type="number" class="budget-input" data-category="Lainnya"
                                        placeholder="Budget (Rp)" min="0">
                                </div>
                                <div class="form-group" style="margin: 0;">
                                    <label>Pengeluaran Aktual</label>
                                    <input type="text" class="actual-display" data-category="Lainnya" readonly>
                                </div>
                                <button class="btn btn-primary" onclick="saveCategoryBudget('Lainnya')">💾
                                    Simpan</button>
                            </div>
                            <div class="progress-bar" style="margin-top: 15px;">
                                <div class="progress-fill good" id="progress-Lainnya" style="width: 0%">0%</div>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 30px;">
                        <button class="btn btn-success" onclick="saveAllBudgets()"
                            style="font-size: 18px; padding: 15px 30px;">
                            💾 Simpan Semua Budget
                        </button>
                    </div>
                </div>
            </div>

            <!-- TAB TRANSAKSI -->
            <div id="transactions" class="tab-content">
                <div class="controls">
                    <button class="btn btn-primary" onclick="showAddTransaction()">➕ Tambah Transaksi</button>
                </div>

                <div class="form-section" id="formSection" style="display: none;">
                    <h2>Tambah Transaksi Baru</h2>
                    <form id="transactionForm" onsubmit="addTransaction(event)">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" id="date" required>
                            </div>
                            <div class="form-group">
                                <label>Tipe</label>
                                <select id="type" required onchange="updateCategories()">
                                    <option value="">Pilih Tipe</option>
                                    <option value="income">Pemasukan</option>
                                    <option value="expense">Pengeluaran</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
                                <select id="category" required>
                                    <option value="">Pilih Kategori</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Jumlah (Rp)</label>
                                <input type="number" id="amount" required min="0" step="0.01">
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" id="description" required>
                            </div>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <button type="submit" class="btn btn-primary">💾 Simpan Transaksi</button>
                            <button type="button" class="btn btn-danger" onclick="hideAddTransaction()">❌ Batal</button>
                        </div>
                    </form>
                </div>

                <div class="card">
                    <h2>📋 Daftar Transaksi</h2>
                    <table class="budget-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="transactionsList">
                            <tr>
                                <td colspan="6" style="text-align: center; color: #64748b;">Belum ada transaksi</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB ASET & LIABILITAS -->
            <div id="assets" class="tab-content">
                <div class="controls">
                    <button class="btn btn-success" onclick="showAddAsset('liquid')">💵 Tambah Aset Likuid</button>
                    <button class="btn btn-warning" onclick="showAddAsset('physical')">🏠 Tambah Aset Fisik</button>
                    <button class="btn btn-danger" onclick="showAddLiability()">📉 Tambah Liabilitas</button>
                </div>

                <!-- Form Aset Likuid -->
                <div class="form-section" id="liquidAssetForm" style="display: none;">
                    <h2>💵 Tambah Aset Likuid</h2>
                    <form onsubmit="addLiquidAsset(event)">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nama Aset</label>
                                <input type="text" id="liquidName" required placeholder="Contoh: Tabungan BCA">
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
                                <select id="liquidCategory" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Kas">Kas</option>
                                    <option value="Tabungan">Tabungan</option>
                                    <option value="Deposito">Deposito</option>
                                    <option value="Reksa Dana">Reksa Dana</option>
                                    <option value="Saham">Saham</option>
                                    <option value="Emas">Emas</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nilai (Rp)</label>
                                <input type="number" id="liquidAmount" required min="0" step="0.01">
                            </div>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <button type="submit" class="btn btn-primary">💾 Simpan</button>
                            <button type="button" class="btn btn-danger" onclick="hideAssetForm()">❌ Batal</button>
                        </div>
                    </form>
                </div>

                <!-- Form Aset Fisik -->
                <div class="form-section" id="physicalAssetForm" style="display: none;">
                    <h2>🏠 Tambah Aset Fisik</h2>
                    <form onsubmit="addPhysicalAsset(event)">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nama Aset</label>
                                <input type="text" id="physicalName" required placeholder="Contoh: Rumah di Jakarta">
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
                                <select id="physicalCategory" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Properti">Properti</option>
                                    <option value="Kendaraan">Kendaraan</option>
                                    <option value="Elektronik">Elektronik</option>
                                    <option value="Perhiasan">Perhiasan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nilai (Rp)</label>
                                <input type="number" id="physicalAmount" required min="0" step="0.01">
                            </div>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <button type="submit" class="btn btn-primary">💾 Simpan</button>
                            <button type="button" class="btn btn-danger" onclick="hideAssetForm()">❌ Batal</button>
                        </div>
                    </form>
                </div>

                <!-- Form Liabilitas -->
                <div class="form-section" id="liabilityForm" style="display: none;">
                    <h2>📉 Tambah Liabilitas</h2>
                    <form onsubmit="addLiability(event)">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nama Liabilitas</label>
                                <input type="text" id="liabilityName" required placeholder="Contoh: KPR Rumah">
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
                                <select id="liabilityCategory" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="KPR">KPR</option>
                                    <option value="Kredit Kendaraan">Kredit Kendaraan</option>
                                    <option value="Kartu Kredit">Kartu Kredit</option>
                                    <option value="Pinjaman Bank">Pinjaman Bank</option>
                                    <option value="PayLater">Bayar Nanti</option>
                                    <option value="PayLater">Cicilan Pay Later</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jumlah (Rp)</label>
                                <input type="number" id="liabilityAmount" required min="0" step="0.01">
                            </div>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <button type="submit" class="btn btn-primary">💾 Simpan</button>
                            <button type="button" class="btn btn-danger" onclick="hideAssetForm()">❌ Batal</button>
                        </div>
                    </form>
                </div>

                <!-- Tabel Aset & Liabilitas -->
                <div class="card">
                    <h2>💵 Daftar Aset Likuid</h2>
                    <table class="budget-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="liquidAssetsList">
                            <tr>
                                <td colspan="4" style="text-align: center; color: #64748b;">Belum ada aset likuid</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card">
                    <h2>🏠 Daftar Aset Fisik</h2>
                    <table class="budget-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="physicalAssetsList">
                            <tr>
                                <td colspan="4" style="text-align: center; color: #64748b;">Belum ada aset fisik</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card">
                    <h2>📉 Daftar Liabilitas</h2>
                    <table class="budget-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="liabilitiesList">
                            <tr>
                                <td colspan="4" style="text-align: center; color: #64748b;">Belum ada liabilitas</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB PENGATURAN -->
            <div id="settings" class="tab-content">
                <div class="card">
                    <h2>⚙️ Pengaturan Data</h2>
                    <div class="controls">
                        <button class="btn btn-success" onclick="exportData()">📤 Export Data (JSON)</button>
                        <label class="btn btn-success" style="margin: 0; cursor: pointer;">
                            📥 Import Data (JSON)
                            <input type="file" id="importFile" accept=".json" onchange="importData(event)"
                                style="display: none;">
                        </label>
                        <button class="btn btn-danger" onclick="clearAllData()">🗑️ Hapus Semua Data</button>
                    </div>
                    <div class="alert alert-warning" style="margin-top: 20px;">
                        <strong>⚠️ Informasi Penting:</strong><br>
                        • Export data untuk backup berkala<br>
                        • Import data akan menggantikan data yang ada<br>
                        • Hapus semua data tidak dapat dikembalikan<br>
                        • Data tersimpan di browser Anda (localStorage)
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    const categories = {
        income: ['Gaji', 'Bonus', 'Investasi', 'Freelance', 'Bisnis', 'Lainnya'],
        expense: ['Makanan', 'Belanja', 'Transport', 'Tagihan', 'Cicilan', 'Hiburan', 'Kesehatan', 'Pendidikan',
            'Lainnya'
        ]
    };

    let transactions = [];
    let liquidAssets = [];
    let physicalAssets = [];
    let liabilities = [];
    let budgets = {};
    let pieChart = null;
    let budgetChartObj = null;

    function init() {
        loadData();
        initializeMonthSelectors();
        setDefaultMonth();
        updateDashboard();
        loadBudgetForMonth();
        document.getElementById('date').valueAsDate = new Date();
    }

    function initializeMonthSelectors() {
        const selects = [
            document.getElementById('dashboardMonth'),
            document.getElementById('budgetMonthSelect')
        ];

        const today = new Date();

        selects.forEach(select => {
            if (select.tagName === 'SELECT') {
                select.innerHTML = '';
                for (let i = 0; i < 12; i++) {
                    const d = new Date(today.getFullYear(), today.getMonth() - i, 1);
                    const monthKey = d.toISOString().substring(0, 7);
                    const monthName = d.toLocaleDateString('id-ID', {
                        month: 'long',
                        year: 'numeric'
                    });

                    const option = document.createElement('option');
                    option.value = monthKey;
                    option.textContent = monthName;
                    if (i === 0) option.selected = true;
                    select.appendChild(option);
                }
            }
        });
    }

    function setDefaultMonth() {
        const today = new Date();
        const month = today.toISOString().substring(0, 7);
        const dashMonth = document.getElementById('dashboardMonth');
        if (dashMonth && dashMonth.tagName === 'INPUT') {
            dashMonth.value = month;
        }
    }

    function switchTab(tabName) {
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

        event.target.classList.add('active');
        document.getElementById(tabName).classList.add('active');

        if (tabName === 'budget') {
            loadBudgetForMonth();
        }
    }

    function loadData() {
        const saved = localStorage.getItem('financeData');
        if (saved) {
            const data = JSON.parse(saved);
            transactions = data.transactions || [];
            liquidAssets = data.liquidAssets || [];
            physicalAssets = data.physicalAssets || [];
            liabilities = data.liabilities || [];
            budgets = data.budgets || {};
        }
    }

    function saveData() {
        const data = {
            transactions,
            liquidAssets,
            physicalAssets,
            liabilities,
            budgets
        };
        localStorage.setItem('financeData', JSON.stringify(data));
    }

    // TRANSAKSI FUNCTIONS
    function showAddTransaction() {
        document.getElementById('formSection').style.display = 'block';
        window.scrollTo({
            top: document.getElementById('formSection').offsetTop - 100,
            behavior: 'smooth'
        });
    }

    function hideAddTransaction() {
        document.getElementById('formSection').style.display = 'none';
        document.getElementById('transactionForm').reset();
        document.getElementById('date').valueAsDate = new Date();
    }

    function updateCategories() {
        const type = document.getElementById('type').value;
        const categorySelect = document.getElementById('category');
        categorySelect.innerHTML = '<option value="">Pilih Kategori</option>';

        if (type && categories[type]) {
            categories[type].forEach(cat => {
                const option = document.createElement('option');
                option.value = cat;
                option.textContent = cat;
                categorySelect.appendChild(option);
            });
        }
    }

    function addTransaction(event) {
        event.preventDefault();

        const transaction = {
            id: Date.now(),
            date: document.getElementById('date').value,
            type: document.getElementById('type').value,
            category: document.getElementById('category').value,
            amount: parseFloat(document.getElementById('amount').value),
            description: document.getElementById('description').value
        };

        transactions.push(transaction);
        saveData();
        updateDashboard();
        loadBudgetForMonth();
        hideAddTransaction();

        alert('✅ Transaksi berhasil ditambahkan!');
    }

    function deleteTransaction(id) {
        if (confirm('Yakin ingin menghapus transaksi ini?')) {
            transactions = transactions.filter(t => t.id !== id);
            saveData();
            updateDashboard();
            loadBudgetForMonth();
        }
    }

    // ASSET FUNCTIONS
    function showAddAsset(type) {
        hideAssetForm();
        if (type === 'liquid') {
            document.getElementById('liquidAssetForm').style.display = 'block';
        } else {
            document.getElementById('physicalAssetForm').style.display = 'block';
        }
    }

    function showAddLiability() {
        hideAssetForm();
        document.getElementById('liabilityForm').style.display = 'block';
    }

    function hideAssetForm() {
        document.getElementById('liquidAssetForm').style.display = 'none';
        document.getElementById('physicalAssetForm').style.display = 'none';
        document.getElementById('liabilityForm').style.display = 'none';
    }

    function addLiquidAsset(event) {
        event.preventDefault();
        const asset = {
            id: Date.now(),
            name: document.getElementById('liquidName').value,
            category: document.getElementById('liquidCategory').value,
            amount: parseFloat(document.getElementById('liquidAmount').value)
        };
        liquidAssets.push(asset);
        saveData();
        updateDashboard();
        hideAssetForm();
        event.target.reset();
        alert('✅ Aset likuid berhasil ditambahkan!');
    }

    function addPhysicalAsset(event) {
        event.preventDefault();
        const asset = {
            id: Date.now(),
            name: document.getElementById('physicalName').value,
            category: document.getElementById('physicalCategory').value,
            amount: parseFloat(document.getElementById('physicalAmount').value)
        };
        physicalAssets.push(asset);
        saveData();
        updateDashboard();
        hideAssetForm();
        event.target.reset();
        alert('✅ Aset fisik berhasil ditambahkan!');
    }

    function addLiability(event) {
        event.preventDefault();
        const liability = {
            id: Date.now(),
            name: document.getElementById('liabilityName').value,
            category: document.getElementById('liabilityCategory').value,
            amount: parseFloat(document.getElementById('liabilityAmount').value)
        };
        liabilities.push(liability);
        saveData();
        updateDashboard();
        hideAssetForm();
        event.target.reset();
        alert('✅ Liabilitas berhasil ditambahkan!');
    }

    function deleteLiquidAsset(id) {
        if (confirm('Yakin ingin menghapus aset ini?')) {
            liquidAssets = liquidAssets.filter(a => a.id !== id);
            saveData();
            updateDashboard();
        }
    }

    function deletePhysicalAsset(id) {
        if (confirm('Yakin ingin menghapus aset ini?')) {
            physicalAssets = physicalAssets.filter(a => a.id !== id);
            saveData();
            updateDashboard();
        }
    }

    function deleteLiability(id) {
        if (confirm('Yakin ingin menghapus liabilitas ini?')) {
            liabilities = liabilities.filter(l => l.id !== id);
            saveData();
            updateDashboard();
        }
    }

    // BUDGET FUNCTIONS
    function loadBudgetForMonth() {
        const monthSelect = document.getElementById('budgetMonthSelect');
        const selectedMonth = monthSelect ? monthSelect.value : new Date().toISOString().substring(0, 7);

        const monthBudget = budgets[selectedMonth] || {};
        const monthExpenses = getExpensesForMonth(selectedMonth);

        let totalBudget = 0;
        let totalSpent = 0;

        categories.expense.forEach(category => {
            const budgetInput = document.querySelector(`.budget-input[data-category="${category}"]`);
            const actualDisplay = document.querySelector(`.actual-display[data-category="${category}"]`);
            const progressBar = document.getElementById(`progress-${category}`);

            const budgetAmount = monthBudget[category] || 0;
            const spentAmount = monthExpenses[category] || 0;

            if (budgetInput) budgetInput.value = budgetAmount || '';
            if (actualDisplay) actualDisplay.value = formatCurrency(spentAmount);

            totalBudget += budgetAmount;
            totalSpent += spentAmount;

            if (progressBar && budgetAmount > 0) {
                const percentage = (spentAmount / budgetAmount * 100).toFixed(1);
                const cappedPercentage = Math.min(percentage, 100);

                progressBar.style.width = cappedPercentage + '%';
                progressBar.textContent = percentage + '%';

                progressBar.className = 'progress-fill';
                if (percentage < 80) {
                    progressBar.classList.add('good');
                } else if (percentage < 100) {
                    progressBar.classList.add('warning');
                } else {
                    progressBar.classList.add('danger');
                }
            }
        });

        const remaining = totalBudget - totalSpent;
        const percentage = totalBudget > 0 ? (totalSpent / totalBudget * 100).toFixed(1) : 0;

        document.getElementById('totalBudget').textContent = formatCurrency(totalBudget);
        document.getElementById('totalSpent').textContent = formatCurrency(totalSpent);
        document.getElementById('remainingBudget').textContent = formatCurrency(remaining);
        document.getElementById('remainingBudget').style.color = remaining >= 0 ? '#10b981' : '#ef4444';
        document.getElementById('budgetPercentage').textContent = percentage + '%';
        document.getElementById('budgetPercentage').style.color = percentage < 80 ? '#10b981' : percentage < 100 ?
            '#f59e0b' : '#ef4444';

        showBudgetAlerts(monthBudget, monthExpenses);
        updateBudgetChart(monthBudget, monthExpenses);
    }

    function getExpensesForMonth(month) {
        const expenses = {};
        transactions
            .filter(t => t.type === 'expense' && t.date.startsWith(month))
            .forEach(t => {
                if (!expenses[t.category]) expenses[t.category] = 0;
                expenses[t.category] += t.amount;
            });
        return expenses;
    }

    function saveCategoryBudget(category) {
        const monthSelect = document.getElementById('budgetMonthSelect');
        const selectedMonth = monthSelect ? monthSelect.value : new Date().toISOString().substring(0, 7);

        const budgetInput = document.querySelector(`.budget-input[data-category="${category}"]`);
        const amount = parseFloat(budgetInput.value) || 0;

        if (!budgets[selectedMonth]) budgets[selectedMonth] = {};
        budgets[selectedMonth][category] = amount;

        saveData();
        loadBudgetForMonth();
        alert(`✅ Budget ${category} berhasil disimpan!`);
    }

    function saveAllBudgets() {
        const monthSelect = document.getElementById('budgetMonthSelect');
        const selectedMonth = monthSelect ? monthSelect.value : new Date().toISOString().substring(0, 7);

        if (!budgets[selectedMonth]) budgets[selectedMonth] = {};

        categories.expense.forEach(category => {
            const budgetInput = document.querySelector(`.budget-input[data-category="${category}"]`);
            const amount = parseFloat(budgetInput.value) || 0;
            budgets[selectedMonth][category] = amount;
        });

        saveData();
        loadBudgetForMonth();
        alert('✅ Semua budget berhasil disimpan!');
    }

    function copyPreviousBudget() {
        const monthSelect = document.getElementById('budgetMonthSelect');
        const selectedMonth = monthSelect ? monthSelect.value : new Date().toISOString().substring(0, 7);

        const date = new Date(selectedMonth + '-01');
        date.setMonth(date.getMonth() - 1);
        const prevMonth = date.toISOString().substring(0, 7);

        if (budgets[prevMonth]) {
            if (confirm(`Copy budget dari ${date.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })}?`)) {
                budgets[selectedMonth] = {
                    ...budgets[prevMonth]
                };
                saveData();
                loadBudgetForMonth();
                alert('✅ Budget berhasil di-copy!');
            }
        } else {
            alert('⚠️ Tidak ada budget di bulan sebelumnya');
        }
    }

    function autoSuggestBudget() {
        const monthSelect = document.getElementById('budgetMonthSelect');
        const selectedMonth = monthSelect ? monthSelect.value : new Date().toISOString().substring(0, 7);

        const date = new Date(selectedMonth + '-01');
        const last3Months = [];

        for (let i = 1; i <= 3; i++) {
            const d = new Date(date.getFullYear(), date.getMonth() - i, 1);
            last3Months.push(d.toISOString().substring(0, 7));
        }

        const avgExpenses = {};
        categories.expense.forEach(category => {
            const amounts = [];
            last3Months.forEach(month => {
                const monthExpenses = getExpensesForMonth(month);
                if (monthExpenses[category]) amounts.push(monthExpenses[category]);
            });

            if (amounts.length > 0) {
                const avg = amounts.reduce((a, b) => a + b, 0) / amounts.length;
                avgExpenses[category] = Math.ceil(avg / 10000) * 10000;
            }
        });

        if (Object.keys(avgExpenses).length === 0) {
            alert('⚠️ Tidak ada data pengeluaran 3 bulan terakhir untuk dijadikan acuan');
            return;
        }

        if (confirm('Auto suggest akan menghitung rata-rata pengeluaran 3 bulan terakhir. Lanjutkan?')) {
            if (!budgets[selectedMonth]) budgets[selectedMonth] = {};

            Object.keys(avgExpenses).forEach(category => {
                budgets[selectedMonth][category] = avgExpenses[category];
            });

            saveData();
            loadBudgetForMonth();
            alert('✅ Budget berhasil di-suggest berdasarkan rata-rata 3 bulan terakhir!');
        }
    }

    function showBudgetAlerts(monthBudget, monthExpenses) {
        const alertsDiv = document.getElementById('budgetAlerts');
        alertsDiv.innerHTML = '';

        const alerts = [];

        categories.expense.forEach(category => {
            const budget = monthBudget[category] || 0;
            const spent = monthExpenses[category] || 0;

            if (budget > 0) {
                const percentage = (spent / budget * 100);

                if (percentage >= 100) {
                    alerts.push({
                        type: 'danger',
                        message: `❌ Budget <strong>${category}</strong> sudah terlampaui (${percentage.toFixed(0)}%)!`
                    });
                } else if (percentage >= 80) {
                    alerts.push({
                        type: 'warning',
                        message: `⚠️ Budget <strong>${category}</strong> hampir habis (${percentage.toFixed(0)}%)!`
                    });
                }
            }
        });

        if (alerts.length > 0) {
            alerts.forEach(alert => {
                const div = document.createElement('div');
                div.className = `alert alert-${alert.type}`;
                div.innerHTML = alert.message;
                alertsDiv.appendChild(div);
            });
        }
    }

    // DASHBOARD FUNCTIONS
    function updateDashboard() {
        const monthInput = document.getElementById('dashboardMonth');
        const selectedMonth = monthInput ? monthInput.value : new Date().toISOString().substring(0, 7);

        const filtered = transactions.filter(t => t.date.startsWith(selectedMonth));

        updateAssetSummary();
        updateCashflowSummary(filtered, selectedMonth);
        updatePieChart(filtered);
        updateTransactionsList(filtered);
        updateAssetLists();
    }

    function updateAssetSummary() {
        const totalLiquid = liquidAssets.reduce((sum, a) => sum + a.amount, 0);
        const totalPhysical = physicalAssets.reduce((sum, a) => sum + a.amount, 0);
        const totalLiability = liabilities.reduce((sum, l) => sum + l.amount, 0);
        const totalAsset = totalLiquid + totalPhysical;
        const netWorth = totalAsset - totalLiability;

        document.getElementById('dashTotalAssets').textContent = formatCurrency(totalAsset);
        document.getElementById('dashTotalLiabilities').textContent = formatCurrency(totalLiability);
        document.getElementById('netWorth').textContent = formatCurrency(netWorth);
    }

    function updateCashflowSummary(filtered, selectedMonth) {
        const income = filtered.filter(t => t.type === 'income').reduce((sum, t) => sum + t.amount, 0);
        const expense = filtered.filter(t => t.type === 'expense').reduce((sum, t) => sum + t.amount, 0);
        const balance = income - expense;

        const monthBudget = budgets[selectedMonth] || {};
        const totalBudget = Object.values(monthBudget).reduce((sum, val) => sum + val, 0);
        const budgetUsage = totalBudget > 0 ? ((expense / totalBudget) * 100).toFixed(1) : 0;

        document.getElementById('dashIncome').textContent = formatCurrency(income);
        document.getElementById('dashExpense').textContent = formatCurrency(expense);
        document.getElementById('dashBalance').textContent = formatCurrency(balance);
        document.getElementById('dashBalance').style.color = balance >= 0 ? '#10b981' : '#ef4444';
        document.getElementById('dashBudgetUsage').textContent = budgetUsage + '%';
        document.getElementById('dashBudgetUsage').style.color = budgetUsage < 80 ? '#10b981' : budgetUsage < 100 ?
            '#f59e0b' : '#ef4444';
    }

    function updatePieChart(filtered) {
        const categoryData = {};

        filtered.filter(t => t.type === 'expense').forEach(t => {
            if (!categoryData[t.category]) categoryData[t.category] = 0;
            categoryData[t.category] += t.amount;
        });

        const labels = Object.keys(categoryData);
        const data = Object.values(categoryData);
        const colors = ['#667eea', '#764ba2', '#f093fb', '#4facfe', '#43e97b', '#fa709a', '#fee140', '#30cfd0',
            '#f59e0b'
        ];

        const ctx = document.getElementById('pieChart').getContext('2d');

        if (pieChart) pieChart.destroy();

        if (labels.length === 0) {
            pieChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Belum ada data'],
                    datasets: [{
                        data: [1],
                        backgroundColor: ['#e2e8f0']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        } else {
            pieChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors.slice(0, labels.length)
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = formatCurrency(context.parsed);
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.parsed / total) * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    function updateBudgetChart(monthBudget, monthExpenses) {
        const ctx = document.getElementById('budgetChart');
        if (!ctx) return;

        const ctxChart = ctx.getContext('2d');

        if (budgetChartObj) budgetChartObj.destroy();

        const labels = categories.expense;
        const budgetData = labels.map(cat => monthBudget[cat] || 0);
        const actualData = labels.map(cat => monthExpenses[cat] || 0);

        budgetChartObj = new Chart(ctxChart, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Budget',
                    data: budgetData,
                    backgroundColor: '#667eea'
                }, {
                    label: 'Actual',
                    data: actualData,
                    backgroundColor: '#10b981'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + formatCurrency(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                            }
                        }
                    }
                }
            }
        });
    }

    function updateTransactionsList(filtered) {
        const tbody = document.getElementById('transactionsList');

        if (filtered.length === 0) {
            tbody.innerHTML =
                '<tr><td colspan="6" style="text-align: center; color: #64748b;">Belum ada transaksi</td></tr>';
            return;
        }

        const sorted = filtered.sort((a, b) => new Date(b.date) - new Date(a.date));

        tbody.innerHTML = sorted.map(t => `
                <tr>
                    <td>${formatDate(t.date)}</td>
                    <td><span class="badge badge-${t.type}">${t.type === 'income' ? 'Pemasukan' : 'Pengeluaran'}</span></td>
                    <td>${t.category}</td>
                    <td>${t.description}</td>
                    <td style="font-weight: bold; color: ${t.type === 'income' ? '#10b981' : '#ef4444'}">
                        ${formatCurrency(t.amount)}
                    </td>
                    <td><button class="btn btn-danger" style="padding: 6px 12px; font-size: 0.85em;" onclick="deleteTransaction(${t.id})">Hapus</button></td>
                </tr>
            `).join('');
    }

    function updateAssetLists() {
        updateLiquidAssetsList();
        updatePhysicalAssetsList();
        updateLiabilitiesList();
    }

    function updateLiquidAssetsList() {
        const tbody = document.getElementById('liquidAssetsList');

        if (liquidAssets.length === 0) {
            tbody.innerHTML =
                '<tr><td colspan="4" style="text-align: center; color: #64748b;">Belum ada aset likuid</td></tr>';
            return;
        }

        tbody.innerHTML = liquidAssets.map(a => `
                <tr>
                    <td><strong>${a.name}</strong></td>
                    <td><span class="badge" style="background: #dbeafe; color: #1e40af;">${a.category}</span></td>
                    <td style="font-weight: bold; color: #10b981;">${formatCurrency(a.amount)}</td>
                    <td><button class="btn btn-danger" style="padding: 6px 12px; font-size: 0.85em;" onclick="deleteLiquidAsset(${a.id})">Hapus</button></td>
                </tr>
            `).join('');
    }

    function updatePhysicalAssetsList() {
        const tbody = document.getElementById('physicalAssetsList');

        if (physicalAssets.length === 0) {
            tbody.innerHTML =
                '<tr><td colspan="4" style="text-align: center; color: #64748b;">Belum ada aset fisik</td></tr>';
            return;
        }

        tbody.innerHTML = physicalAssets.map(a => `
                <tr>
                    <td><strong>${a.name}</strong></td>
                    <td><span class="badge" style="background: #fef3c7; color: #92400e;">${a.category}</span></td>
                    <td style="font-weight: bold; color: #f59e0b;">${formatCurrency(a.amount)}</td>
                    <td><button class="btn btn-danger" style="padding: 6px 12px; font-size: 0.85em;" onclick="deletePhysicalAsset(${a.id})">Hapus</button></td>
                </tr>
            `).join('');
    }

    function updateLiabilitiesList() {
        const tbody = document.getElementById('liabilitiesList');

        if (liabilities.length === 0) {
            tbody.innerHTML =
                '<tr><td colspan="4" style="text-align: center; color: #64748b;">Belum ada liabilitas</td></tr>';
            return;
        }

        tbody.innerHTML = liabilities.map(l => `
                <tr>
                    <td><strong>${l.name}</strong></td>
                    <td><span class="badge badge-expense">${l.category}</span></td>
                    <td style="font-weight: bold; color: #ef4444;">${formatCurrency(l.amount)}</td>
                    <td><button class="btn btn-danger" style="padding: 6px 12px; font-size: 0.85em;" onclick="deleteLiability(${l.id})">Hapus</button></td>
                </tr>
            `).join('');
    }

    function formatCurrency(amount) {
        return 'Rp ' + amount.toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
    }

    function formatDate(dateString) {
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        return new Date(dateString).toLocaleDateString('id-ID', options);
    }

    function exportData() {
        const data = {
            transactions,
            liquidAssets,
            physicalAssets,
            liabilities,
            budgets,
            exportDate: new Date().toISOString()
        };
        const dataStr = JSON.stringify(data, null, 2);
        const dataBlob = new Blob([dataStr], {
            type: 'application/json'
        });
        const url = URL.createObjectURL(dataBlob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `keuangan-backup-${new Date().toISOString().split('T')[0]}.json`;
        link.click();
        URL.revokeObjectURL(url);
        alert('✅ Data berhasil di-export!');
    }

    function importData(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const imported = JSON.parse(e.target.result);
                if (confirm('Import data akan menggantikan data yang ada. Lanjutkan?')) {
                    transactions = imported.transactions || [];
                    liquidAssets = imported.liquidAssets || [];
                    physicalAssets = imported.physicalAssets || [];
                    liabilities = imported.liabilities || [];
                    budgets = imported.budgets || {};
                    saveData();
                    updateDashboard();
                    loadBudgetForMonth();
                    alert('✅ Data berhasil di-import!');
                }
            } catch (error) {
                alert('❌ Error membaca file: ' + error.message);
            }
            event.target.value = '';
        };
        reader.readAsText(file);
    }

    function clearAllData() {
        if (confirm('⚠️ PERINGATAN: Ini akan menghapus SEMUA data. Apakah Anda yakin?')) {
            if (confirm('Yakin ingin melanjutkan? Data tidak dapat dikembalikan!')) {
                transactions = [];
                liquidAssets = [];
                physicalAssets = [];
                liabilities = [];
                budgets = {};
                saveData();
                updateDashboard();
                loadBudgetForMonth();
                alert('✅ Semua data berhasil dihapus!');
            }
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', init);
    </script>
</body>

</html>