<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dekan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
        }

        .navbar {
            background: #FB8C00;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar h2 {
            font-size: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info span {
            background: #34495e;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
        }

        .logout-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #c0392b;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #3498db;
        }

        .stat-card h3 {
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .stat-card .number {
            font-size: 36px;
            font-weight: bold;
            color: #2c3e50;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ecf0f1;
        }

        .card-header h3 {
            color: #2c3e50;
            font-size: 20px;
        }

        .filter-btn {
            background: #3498db;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .filter-btn:hover {
            background: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #ecf0f1;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #ecf0f1;
            font-size: 14px;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .btn-group {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
        }

        .btn-detail {
            background: #3498db;
            color: white;
        }

        .btn-detail:hover {
            background: #2980b9;
        }

        .btn-approve {
            background: #27ae60;
            color: white;
        }

        .btn-approve:hover {
            background: #229954;
        }

        .btn-reject {
            background: #e74c3c;
            color: white;
        }

        .btn-reject:hover {
            background: #c0392b;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #7f8c8d;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background: white;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ecf0f1;
        }

        .close {
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            color: #7f8c8d;
        }

        .close:hover {
            color: #2c3e50;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 200px 1fr;
            padding: 12px 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .detail-label {
            font-weight: 600;
            color: #7f8c8d;
        }

        .detail-value {
            color: #2c3e50;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: inherit;
            margin-top: 10px;
            resize: vertical;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <h2>📋 Dashboard Dekan</h2>
    </div>
    <!-- Container -->
    <div class="container">
        <!-- Alert Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-error">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div id="alertContainer"></div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Menunggu Persetujuan</h3>
                <div class="number" id="pendingCount"><?php echo isset($pending_count) ? $pending_count : 0; ?></div>
            </div>
            <div class="stat-card" style="border-left-color: #27ae60;">
                <h3>Disetujui Bulan Ini</h3>
                <div class="number" id="approvedCount"><?php echo isset($approved_count) ? $approved_count : 0; ?></div>
            </div>
            <div class="stat-card" style="border-left-color: #e74c3c;">
                <h3>Ditolak Bulan Ini</h3>
                <div class="number" id="rejectedCount"><?php echo isset($rejected_count) ? $rejected_count : 0; ?></div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card">
            <div class="card-header">
                <h3>Daftar Pengajuan Surat</h3>
            </div>

            <!-- Table -->
            <div style="overflow-x: auto;">
                <table id="suratTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kegiatan</th>
                            <th>Penyelenggara</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Kegiatan</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
            </div>

            <div id="emptyState" class="empty-state" style="display: none;">
                <div style="font-size: 64px; opacity: 0.3;">📭</div>
                <h3>Tidak ada pengajuan surat</h3>
                <p>Belum ada pengajuan yang menunggu persetujuan Anda</p>
            </div>
        </div>
    </div>

    <!-- Modal Reject -->
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Tolak Pengajuan</h3>
                <span class="close" onclick="closeModal('rejectModal')">&times;</span>
            </div>
            <p style="margin-bottom: 15px;">Berikan alasan penolakan:</p>
            <textarea id="rejectionNotes" rows="5" placeholder="Masukkan alasan penolakan..."></textarea>
            <div style="margin-top: 20px; text-align: right;">
                <button class="btn btn-reject" onclick="confirmReject()">Tolak Pengajuan</button>
            </div>
        </div>
    </div>


    <script>
        // Data dari database PHP - di-pass dari controller
        let currentRejectId = null;
        const sampleData = <?php echo json_encode($surat_list); ?>;

        // Update stats dari database
        const stats = {
            pending: <?php echo isset($pending_count) ? $pending_count : 0; ?>,
            approved: <?php echo isset($approved_count) ? $approved_count : 0; ?>,
            rejected: <?php echo isset($rejected_count) ? $rejected_count : 0; ?>
        };

        // Load data on page load
        window.onload = function() {
            loadTableData();
        };

        function loadTableData() {
            const tbody = document.getElementById('tableBody');
            const emptyState = document.getElementById('emptyState');

            if (sampleData.length === 0) {
                tbody.innerHTML = '';
                emptyState.style.display = 'block';
                return;
            }

            emptyState.style.display = 'none';
            tbody.innerHTML = sampleData.map((item, index) => `
            <tr>
                <td>${index + 1}</td>
                <td><strong>${item.nama_kegiatan}</strong></td>
                <td>${item.penyelenggara}<br><small style="color: #7f8c8d;"></small></td>
                <td>${formatDate(item.tanggal_pengajuan)}</td>
                <td>${formatDate(item.tanggal_kegiatan)}</td>
                <td>${item.jenis_pengajuan}</td>
                <td>${item.status}</td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-approve" onclick="approveSurat(${item.id})">✓ Setuju</button>
                        <button class="btn btn-reject" onclick="showRejectModal(${item.id})">✗ Tolak</button>
                    </div>
                </td>
            </tr>
        `).join('');
        }

        function formatDate(dateStr) {
            const date = new Date(dateStr);
            const options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            };
            return date.toLocaleDateString('id-ID', options);
        }

        function showDetail(id) {
            const item = sampleData.find(s => s.id === id);
            if (!item) return;

            const content = `
            <div class="detail-row">
                <div class="detail-label">Nama Kegiatan:</div>
                <div class="detail-value">${item.nama_kegiatan}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Nama Dosen:</div>
                <div class="detail-value">${item.nama_dosen}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">NIP:</div>
                <div class="detail-value">${item.nip}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Jabatan:</div>
                <div class="detail-value">${item.jabatan}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Divisi:</div>
                <div class="detail-value">${item.divisi}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Tanggal Pengajuan:</div>
                <div class="detail-value">${formatDate(item.tanggal_pengajuan)}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Jenis Date:</div>
                <div class="detail-value">${item.jenis_date}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Tanggal Kegiatan:</div>
                <div class="detail-value">${formatDate(item.tanggal_kegiatan)} s/d ${formatDate(item.akhir_kegiatan)}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Periode Pengusasan:</div>
                <div class="detail-value">${item.periode_pengusasan} (${item.periode_value})</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Akhir Periode:</div>
                <div class="detail-value">${formatDate(item.akhir_periode_pengusasan)}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Jenis Pengajuan:</div>
                <div class="detail-value">${item.jenis_pengajuan}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Tempat Kegiatan:</div>
                <div class="detail-value">${item.tempat_kegiatan}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Penyelenggara:</div>
                <div class="detail-value">${item.penyelenggara}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Lingkup Penugasan:</div>
                <div class="detail-value">${item.lingkup_penugasan}</div>
            </div>
            ${item.jenis_penugasan_perorangan ? `
            <div class="detail-row">
                <div class="detail-label">Jenis Penugasan:</div>
                <div class="detail-value">${item.jenis_penugasan_perorangan}</div>
            </div>
            ` : ''}
            ${item.jenis_penugasan_kelompok ? `
            <div class="detail-row">
                <div class="detail-label">Jenis Penugasan:</div>
                <div class="detail-value">${item.jenis_penugasan_kelompok}</div>
            </div>
            ` : ''}
            <div class="detail-row">
                <div class="detail-label">Format:</div>
                <div class="detail-value">${item.format}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">File Eviden:</div>
                <div class="detail-value">
                    <a href="<?php echo base_url('uploads/'); ?>${item.eviden}" target="_blank" style="color: #3498db; text-decoration: none;">
                        📄 ${item.eviden}
                    </a>
                </div>
            </div>
            <div style="margin-top: 20px; text-align: right;">
                <button class="btn btn-approve" onclick="approveSurat(${item.id}); closeModal('detailModal')">✓ Setujui</button>
                <button class="btn btn-reject" onclick="showRejectModal(${item.id}); closeModal('detailModal')">✗ Tolak</button>
            </div>
        `;

            document.getElementById('detailContent').innerHTML = content;
            document.getElementById('detailModal').style.display = 'block';
        }

        function approveSurat(id) {
            if (confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')) {
                // Redirect ke controller untuk approve
                window.location.href = '<?php echo base_url("dekan/approve/"); ?>' + id;
            }
        }

        function showRejectModal(id) {
            currentRejectId = id;
            document.getElementById('rejectionNotes').value = '';
            document.getElementById('rejectModal').style.display = 'block';
        }

        function confirmReject() {
            const notes = document.getElementById('rejectionNotes').value.trim();

            if (!notes) {
                alert('Alasan penolakan harus diisi!');
                return;
            }

            // Submit form untuk reject
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?php echo base_url("dekan/reject/"); ?>' + currentRejectId;

            // CSRF Token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '<?php echo $this->security->get_csrf_token_name(); ?>';
            csrfInput.value = '<?php echo $this->security->get_csrf_hash(); ?>';
            form.appendChild(csrfInput);

            // Rejection notes
            const notesInput = document.createElement('input');
            notesInput.type = 'hidden';
            notesInput.name = 'rejection_notes';
            notesInput.value = notes;
            form.appendChild(notesInput);

            document.body.appendChild(form);
            form.submit();
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function updateStats() {
            document.getElementById('pendingCount').textContent = sampleData.length;
        }

        function filterData() {
            alert('Fitur filter akan segera ditambahkan');
        }

        function logout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                window.location.href = '<?php echo base_url("auth/logout"); ?>';
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const detailModal = document.getElementById('detailModal');
            const rejectModal = document.getElementById('rejectModal');
            if (event.target == detailModal) {
                detailModal.style.display = 'none';
            }
            if (event.target == rejectModal) {
                rejectModal.style.display = 'none';
            }
        }
    </script>