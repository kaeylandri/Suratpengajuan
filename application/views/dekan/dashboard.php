<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Dekan</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;}
    .navbar{background:#FB8C00;color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
    .navbar h2{font-size:20px;}
    .container{max-width:1200px;margin:30px auto;padding:0 20px;}
    .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:20px;}
    .stat-card{background:white;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06);border-left:4px solid #3498db;}
    .stat-card h3{color:#7f8c8d;font-size:13px;margin-bottom:8px;text-transform:uppercase}
    .stat-card .number{font-size:28px;font-weight:700;color:#2c3e50}
    .card{background:white;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,0.06);margin-bottom:20px}
    .card-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid #eee}
    table{width:100%;border-collapse:collapse}
    thead{background:#f4f6f7}
    th,td{padding:12px;border-bottom:1px solid #ecf0f1;text-align:left;font-size:14px}
    tbody tr:hover{background:#fbfcfd}
    .badge{display:inline-block;padding:6px 10px;border-radius:999px;font-weight:600;font-size:12px}
    .badge-pending{background:#fff3cd;color:#856404}
    .badge-approved{background:#d4edda;color:#155724}
    .badge-rejected{background:#f8d7da;color:#721c24}
    .btn{padding:6px 10px;border-radius:6px;border:0;cursor:pointer;font-weight:600}
    .btn-approve{background:#27ae60;color:#fff}
    .btn-reject{background:#e74c3c;color:#fff}
    .btn-detail{background:#3498db;color:#fff}
    .empty-state{text-align:center;padding:40px;color:#7f8c8d}
    /* Modal */
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.45);align-items:center;justify-content:center}
    .modal.show{display:flex}
    .modal-content{background:white;padding:20px;border-radius:10px;max-width:800px;width:95%;max-height:85vh;overflow:auto}
    .modal-header{display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #eee;padding-bottom:10px;margin-bottom:10px}
    .detail-row{display:grid;grid-template-columns:200px 1fr;padding:8px 0;border-bottom:1px solid #f4f6f7}
    .detail-label{font-weight:700;color:#7f8c8d}
    .detail-value{color:#2c3e50}
</style>
</head>
<body>

<div class="navbar">
    <h2><i class="fa-solid fa-university"></i> Dashboard Dekan</h2>
    <div><!-- bisa diisi user/profile --></div>
</div>

<div class="container">
    <?php if($this->session->flashdata('success')): ?>
    <div class="card" style="border-left:4px solid #27ae60;margin-bottom:18px">
        <div style="color:#155724;font-weight:700"><?php echo $this->session->flashdata('success'); ?></div>
    </div>
<?php endif; ?>
<?php if($this->session->flashdata('error')): ?>
    <div class="card" style="border-left:4px solid #e74c3c;margin-bottom:18px">
        <div style="color:#721c24;font-weight:700"><?php echo $this->session->flashdata('error'); ?></div>
    </div>
<?php endif; ?>

<?php
// -------------------------------
// Defensive: jika controller sudah menyiapkan counts gunakan itu.
// Jika tidak, hitung langsung dari $surat_list yang dipass.
// -------------------------------
$months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
$monthly_total = array_fill(0,12,0);
$monthly_approved = array_fill(0,12,0);
$monthly_rejected = array_fill(0,12,0);
$monthly_pending = array_fill(0,12,0);

$total_all = 0;
$approved_count = (isset($approved_count) && is_numeric($approved_count)) ? (int)$approved_count : 0;
$rejected_count = (isset($rejected_count) && is_numeric($rejected_count)) ? (int)$rejected_count : 0;
$pending_count  = (isset($pending_count)  && is_numeric($pending_count))  ? (int)$pending_count  : 0;


// If controller didn't set counts, compute from $surat_list
// hitung ulang dari surat_list jika controller tidak mengirim count
if (!isset($approved_count) || !isset($rejected_count) || !isset($pending_count)) {

    // reset
    $total_all = 0;
    $approved_count = 0;
    $rejected_count = 0;
    $pending_count = 0;

    if (isset($surat_list) && is_array($surat_list)) {
        foreach ($surat_list as $s) {
            $total_all++;
            // normalize status: accept 'pending','menunggu', 'disetujui','approved','ditolak','rejected'
            $status_raw = isset($s['status']) ? trim(strtolower($s['status'])) : '';
            // map Indonesian words
            if ($status_raw === 'menunggu') $status_raw = 'pending';
            if ($status_raw === 'disetujui' || $status_raw === 'setuju') $status_raw = 'approved';
            if ($status_raw === 'ditolak') $status_raw = 'rejected';

            if ($status_raw === 'approved') $approved_count++;
            elseif ($status_raw === 'rejected') $rejected_count++;
            else $pending_count++;

            // monthly aggregation based on tanggal_pengajuan
            $tgl = isset($s['tanggal_pengajuan']) ? $s['tanggal_pengajuan'] : null;
            if ($tgl) {
                // try parse
                $ts = strtotime($tgl);
                if ($ts !== false) {
                    $m = (int)date('n', $ts) - 1; // 0-based index
                    if ($m >= 0 && $m <= 11) {
                        $monthly_total[$m]++;

                        if ($status_raw === 'approved') $monthly_approved[$m]++;
                        elseif ($status_raw === 'rejected') $monthly_rejected[$m]++;
                        else $monthly_pending[$m]++;
                    }
                }
            }
        }
    }
}
// if controller provided total_all override only if not computed
if (!isset($total_all) || $total_all == 0) {
    // fallback: compute sum of monthly_total
    $total_all = array_sum($monthly_total);
}
?>
        <!-- Statistik ringkas -->
<div class="stats-grid">
    <div class="stat-card" style="border-left-color:#3498db;">
        <h3>Total Pengajuan</h3>
        <div class="number" id="totalAll"><?= (int)$total_all ?></div>
    </div>
    
    <div class="stat-card" style="border-left-color:#27ae60;">
        <h3>Disetujui</h3>
        <div class="number" id="approvedCount"><?= (int)$approved_count ?></div>
    </div>
    
    <div class="stat-card" style="border-left-color:#e74c3c;">
        <h3>Ditolak</h3>
        <div class="number" id="rejectedCount"><?= (int)$rejected_count ?></div>
    </div>
    
    <div class="stat-card" style="border-left-color:#f39c12;">
        <h3>Menunggu Persetujuan</h3>
        <div class="number" id="pendingCount"><?= (int)$pending_count ?></div>
    </div>
</div>
 <!-- Grafik Tren Bulanan -->
        <div class="card">
            <div class="card-header">
                <h3>Grafik Tren Pengajuan (Per Bulan)</h3>
                <div style="font-size:13px;color:#7f8c8d">Total / Disetujui / Ditolak</div>
            </div>
            <canvas id="chartSurat" height="120"></canvas>
        </div>

<!-- Tabel Pengajuan -->
<div class="card">
    <div class="card-header">
        <h3>Daftar Pengajuan Surat</h3>
        <div>
            <!-- bisa ditaruh filter nanti -->
        </div>
    </div>
    
    <div style="overflow-x:auto">
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
                <?php if (isset($surat_list) && is_array($surat_list) && count($surat_list) > 0): ?>
                    <?php $i = 1; foreach ($surat_list as $item): 
                        // normalize status for display & logic
                        $st_raw = isset($item['status']) ? trim($item['status']) : '';
                        $st_l = strtolower($st_raw);
                        if ($st_l === 'menunggu') $st_key = 'pending';
                        elseif ($st_l === 'disetujui' || $st_l === 'setuju' || $st_l === 'approved') $st_key = 'approved';
                        elseif ($st_l === 'ditolak' || $st_l === 'rejected') $st_key = 'rejected';
                        else $st_key = 'pending';
                        // badge
                        if ($st_key === 'approved') { $badge = '<span class="badge badge-approved">Disetujui</span>'; }
                        elseif ($st_key === 'rejected') { $badge = '<span class="badge badge-rejected">Ditolak</span>'; }
                        else { $badge = '<span class="badge badge-pending">Menunggu</span>'; }
                        // dates
                        $tgl_pengajuan = isset($item['tanggal_pengajuan']) ? date('d M Y', strtotime($item['tanggal_pengajuan'])) : '-';
                        $tgl_kegiatan = isset($item['tanggal_kegiatan']) ? date('d M Y', strtotime($item['tanggal_kegiatan'])) : '-';
                        ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><strong><?= htmlspecialchars($item['nama_kegiatan'] ?? '-') ?></strong></td>
                        <td><?= htmlspecialchars($item['penyelenggara'] ?? '-') ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan ?></td>
                        <td><?= htmlspecialchars($item['jenis_pengajuan'] ?? '-') ?></td>
                        <td><?= $badge ?></td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <button class="btn btn-detail" onclick="showDetail(<?= (int)$item['id'] ?>)">Detail</button>
                                <?php if ($st_key === 'pending'): ?>
                                    <!-- Aksi approve/reject hanya untuk yang pending -->
                                    <button class="btn btn-approve" onclick="approveSurat(<?= (int)$item['id'] ?>)">✓</button>
                                    <button class="btn btn-reject" onclick="showRejectModal(<?= (int)$item['id'] ?>)">✗</button>
                                    <?php endif; ?>
                                </div>
                        </td>
                    </tr>
                    <?php $i++; endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" style="text-align:center;padding:25px;color:#7f8c8d">Belum ada pengajuan</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
</div> <!-- container -->

<!-- Detail Modal -->
<div id="detailModal" class="modal" onclick="modalClickOutside(event,'detailModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3>Detail Pengajuan</h3>
            <button onclick="closeModal('detailModal')" style="background:none;border:0;font-size:20px;cursor:pointer">&times;</button>
        </div>
        <div id="detailContent">
            <!-- diisi oleh JS -->
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal" onclick="modalClickOutside(event,'rejectModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3>Tolak Pengajuan</h3>
            <button onclick="closeModal('rejectModal')" style="background:none;border:0;font-size:20px;cursor:pointer">&times;</button>
        </div>
        <div>
            <p>Berikan alasan penolakan:</p>
            <textarea id="rejectionNotes" rows="5" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:6px"></textarea>
            <div style="text-align:right;margin-top:12px">
                <button class="btn btn-reject" onclick="confirmReject()">Kirim Penolakan</button>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// ====== Data dari PHP untuk grafik (bulanan) ======
const months = <?= json_encode($months) ?>;
const monthlyTotal = <?= json_encode(array_values($monthly_total)) ?>;
const monthlyApproved = <?= json_encode(array_values($monthly_approved)) ?>;
const monthlyRejected = <?= json_encode(array_values($monthly_rejected)) ?>;

// ====== Render Chart (Line, multi-line) ======
const ctx = document.getElementById('chartSurat').getContext('2d');
const chartSurat = new Chart(ctx, {
    type: 'line',
    data: {
        labels: months,
        datasets: [
            {
                label: 'Total Pengajuan',
                data: monthlyTotal,
                borderWidth: 2,
                tension: 0.3,
                fill: false,
                borderColor: '#3498db',
                pointRadius: 3
            },
            {
                label: 'Disetujui',
                data: monthlyApproved,
                borderWidth: 2,
                tension: 0.3,
                fill: false,
                borderColor: '#27ae60',
                pointRadius: 3
            },
            {
                label: 'Ditolak',
                data: monthlyRejected,
                borderWidth: 2,
                tension: 0.3,
                fill: false,
                borderColor: '#e74c3c',
                pointRadius: 3
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 } }
        }
    }
});

// ====== Detail / Approve / Reject handling ======
let currentRejectId = null;

// convert PHP surat_list to JS for quick lookups (only if $surat_list exists)
const suratList = <?= isset($surat_list) ? json_encode($surat_list) : '[]' ?>;

function findSuratById(id) {
    return suratList.find(s => Number(s.id) === Number(id));
}

function showDetail(id) {
    const item = findSuratById(id);
    if (!item) { alert('Data tidak ditemukan'); return; }

    const getVal = (k) => (item[k] !== undefined && item[k] !== null ? item[k] : '-');

    const content = `
        <div>
            <div class="detail-row"><div class="detail-label">Nama Kegiatan:</div><div class="detail-value">${escapeHtml(getVal('nama_kegiatan'))}</div></div>
            <div class="detail-row"><div class="detail-label">Nama Dosen:</div><div class="detail-value">${escapeHtml(getVal('nama_dosen'))}</div></div>
            <div class="detail-row"><div class="detail-label">NIP:</div><div class="detail-value">${escapeHtml(getVal('nip'))}</div></div>
            <div class="detail-row"><div class="detail-label">Tanggal Pengajuan:</div><div class="detail-value">${formatDate(getVal('tanggal_pengajuan'))}</div></div>
            <div class="detail-row"><div class="detail-label">Tanggal Kegiatan:</div><div class="detail-value">${formatDate(getVal('tanggal_kegiatan'))}</div></div>
            <div class="detail-row"><div class="detail-label">Jenis Pengajuan:</div><div class="detail-value">${escapeHtml(getVal('jenis_pengajuan'))}</div></div>
            <div class="detail-row"><div class="detail-label">Penyelenggara:</div><div class="detail-value">${escapeHtml(getVal('penyelenggara'))}</div></div>
            <div class="detail-row"><div class="detail-label">Lingkup:</div><div class="detail-value">${escapeHtml(getVal('lingkup_penugasan'))}</div></div>
            <div class="detail-row"><div class="detail-label">File Eviden:</div><div class="detail-value">${getVal('eviden') ? '<a href=\"<?= base_url('uploads/') ?>'+escapeHtml(getVal('eviden'))+'" target="_blank">📄 '+escapeHtml(getVal('eviden'))+'</a>' : '-'}</div></div>
            <div style="text-align:right;margin-top:12px">
                ${ (item.status && item.status.toLowerCase().includes('menunggu') || item.status && item.status.toLowerCase().includes('pending')) ? `<button class="btn btn-approve" onclick="approveSurat(${item.id}); closeModal('detailModal')">✓ Setujui</button> <button class="btn btn-reject" onclick="showRejectModal(${item.id}); closeModal('detailModal')">✗ Tolak</button>` : '' }
            </div>
        </div>
    `;
    document.getElementById('detailContent').innerHTML = content;
    document.getElementById('detailModal').classList.add('show');
}

function approveSurat(id) {
    if (!confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')) return;
    // Redirect ke controller untuk approve (controller: sekretariat/approve/{id})
    window.location.href = '<?= base_url("dekan/approve/") ?>' + id;

}

function showRejectModal(id) {
    currentRejectId = id;
    document.getElementById('rejectionNotes').value = '';
    document.getElementById('rejectModal').classList.add('show');
}

function confirmReject() {
    const notes = document.getElementById('rejectionNotes').value.trim();
    if (!notes) { alert('Alasan penolakan harus diisi'); return; }
    // submit via POST form with CSRF token
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= base_url("dekan/reject/") ?>' + currentRejectId;

    // CSRF
    const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
    const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
    const inpCsrf = document.createElement('input'); inpCsrf.type='hidden'; inpCsrf.name=csrfName; inpCsrf.value=csrfHash; form.appendChild(inpCsrf);
    const inpNotes = document.createElement('input'); inpNotes.type='hidden'; inpNotes.name='rejection_notes'; inpNotes.value=notes; form.appendChild(inpNotes);
    document.body.appendChild(form);
    form.submit();
}

function closeModal(id) {
    document.getElementById(id).classList.remove('show');
}

function modalClickOutside(evt, id) {
    if (evt.target && evt.target.id === id) closeModal(id);
}

function formatDate(d) {
    if (!d) return '-';
    const t = new Date(d);
    if (isNaN(t)) return d;
    return t.toLocaleDateString('id-ID', { day:'2-digit', month: 'short', year:'numeric' });
}

function escapeHtml(unsafe) {
    if (unsafe === null || unsafe === undefined) return '-';
    return String(unsafe)
       .replace(/&/g, "&amp;")
       .replace(/</g, "&lt;")
       .replace(/>/g, "&gt;")
       .replace(/\"/g, "&quot;")
       .replace(/'/g, "&#039;");
}
</script>

</body>
</html>
