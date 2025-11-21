<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Sekretariat</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;}
    .navbar{background:#16A085;color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
    .navbar h2{font-size:20px;}
    .container{max-width:1200px;margin:30px auto;padding:0 20px;}
    .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:20px;}
    .stat-card{background:white;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06);border-left:4px solid #3498db;transition:all 0.3s ease;cursor:pointer;text-decoration:none;display:block;color:inherit}
    .stat-card:hover{transform:translateY(-5px);box-shadow:0 8px 16px rgba(0,0,0,0.12)}
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
    .badge-completed{background:#d1ecf1;color:#0c5460}
    .btn{padding:6px 10px;border-radius:6px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s}
    .btn:hover{transform:scale(1.05)}
    .btn-approve{background:#27ae60;color:#fff}
    .btn-approve:hover{background:#229954}
    .btn-reject{background:#e74c3c;color:#fff}
    .btn-reject:hover{background:#c0392b}
    .btn-detail{background:#3498db;color:#fff}
    .btn-detail:hover{background:#2980b9}
    .chart-container{position:relative;height:450px;padding:20px}
    .filter-container{display:flex;gap:15px;margin-bottom:20px;flex-wrap:wrap}
    .filter-select{padding:10px 15px;border-radius:8px;border:2px solid #ddd;font-weight:600;cursor:pointer;min-width:200px}
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.45);align-items:center;justify-content:center}
    .modal.show{display:flex}
    .modal-content{background:white;padding:20px;border-radius:10px;max-width:800px;width:95%;max-height:85vh;overflow:auto;animation:slideIn 0.3s ease}
    @keyframes slideIn{from{transform:translateY(-50px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-header{display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #eee;padding-bottom:10px;margin-bottom:10px}
    .detail-row{display:grid;grid-template-columns:200px 1fr;padding:8px 0;border-bottom:1px solid #f4f6f7}
    .detail-label{font-weight:700;color:#7f8c8d}
    .detail-value{color:#2c3e50}
</style>
</head>
<body>

<div class="navbar">
    <h2><i class="fa-solid fa-clipboard-list"></i> Dashboard Sekretariat</h2>
    <div></div>
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
    // ✅ Data dari controller - hanya status yang relevan dengan sekretariat
    $total_all = isset($total_surat) ? (int)$total_surat : 0;
    $pending_count = isset($pending_count) ? (int)$pending_count : 0;
    $approved_count = isset($approved_count) ? (int)$approved_count : 0;
    $rejected_count = isset($rejected_count) ? (int)$rejected_count : 0;
    ?>

    <!-- ✅ Statistik dengan Link - Konsisten dengan Controller -->
    <div class="stats-grid">
        <a href="<?= base_url('sekretariat/semua') ?>" class="stat-card" style="border-left-color:#3498db;">
            <h3><i class="fa-solid fa-folder"></i> Total Pengajuan</h3>
            <div class="number"><?= $total_all ?></div>
        </a>
        
        <a href="<?= base_url('sekretariat/pending') ?>" class="stat-card" style="border-left-color:#f39c12;">
            <h3><i class="fa-solid fa-clock"></i> Menunggu Persetujuan</h3>
            <div class="number"><?= $pending_count ?></div>
        </a>
        
        <a href="<?= base_url('sekretariat/disetujui') ?>" class="stat-card" style="border-left-color:#27ae60;">
            <h3><i class="fa-solid fa-check-circle"></i> Disetujui</h3>
            <div class="number"><?= $approved_count ?></div>
        </a>
        
        <a href="<?= base_url('sekretariat/ditolak') ?>" class="stat-card" style="border-left-color:#e74c3c;">
            <h3><i class="fa-solid fa-times-circle"></i> Ditolak</h3>
            <div class="number"><?= $rejected_count ?></div>
        </a>
    </div>

    <!-- Filter -->
    <div class="filter-container">
        <div>
            <label style="display:block;margin-bottom:5px;font-weight:600;color:#7f8c8d">
                <i class="fa-solid fa-calendar"></i> Filter Tahun
            </label>
            <select class="filter-select" id="tahunSelect" onchange="updateTahun(this.value)">
                <?php 
                    $currentYear = date('Y');
                    $selectedYear = isset($tahun) ? $tahun : $currentYear;
                    for ($y = $currentYear; $y >= $currentYear - 5; $y--): 
                ?>
                    <option value="<?= $y ?>" <?= ($selectedYear == $y ? 'selected' : '') ?>>Tahun <?= $y ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </div>

    <!-- ✅ Grafik 3D - Hanya Data Sekretariat -->
    <div class="card" style="background: linear-gradient(135deg, #ffffffff 0%, #ffffffff 100%);">
        <div class="card-header" style="border-bottom-color: rgba(0, 0, 0, 0.1)">
            <strong style="color: #000000ff"><i class="fa-solid fa-chart-bar"></i> Grafik Pengajuan Sekretariat — Tahun <?= isset($tahun) ? $tahun : date('Y') ?></strong>
        </div>
        <div class="chart-container">
            <canvas id="grafikSurat"></canvas>
        </div>
    </div>

    <!-- ✅ Tabel - Hanya Status Relevan Sekretariat -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Daftar Pengajuan Surat</h3>
            <div>
                <span id="filterInfo" style="color:#7f8c8d;font-size:13px">Menampilkan: Semua Data (<?= count($surat_list ?? []) ?>)</span>
            </div>
        </div>
        
        <div style="overflow-x:auto">
            <table>
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
                    <?php if(isset($surat_list) && !empty($surat_list)): $no=1; foreach($surat_list as $s): 
                        // ✅ LOGIKA BADGE YANG DIPERBAIKI - SEMUA STATUS DITANGANI DENGAN BENAR
                        $status = $s->status ?? '';
                        $st_key = 'unknown';
                        $badge_text = ucwords($status);
                        
                        if ($status == 'disetujui KK') {
                            $st_key = 'pending';
                            $badge = '<span class="badge badge-pending">Menunggu</span>';
                        } elseif ($status == 'disetujui sekretariat') {
                            $st_key = 'approved';
                            $badge = '<span class="badge badge-approved">Disetujui Sekretariat</span>';
                        } elseif ($status == 'ditolak sekretariat') {
                            $st_key = 'rejected';
                            $badge = '<span class="badge badge-rejected">Ditolak Sekretariat</span>';
                        } elseif ($status == 'disetujui dekan') {
                            $st_key = 'completed';
                            $badge = '<span class="badge badge-completed">Disetujui Dekan</span>';
                        } elseif ($status == 'ditolak dekan') {
                            $st_key = 'rejected';
                            $badge = '<span class="badge badge-rejected">Ditolak Dekan</span>';
                        } elseif (strpos($status, 'pengajuan') !== false || strpos($status, 'pending') !== false || strpos($status, 'menunggu') !== false) {
                            $st_key = 'pending';
                            $badge = '<span class="badge badge-pending">' . $badge_text . '</span>';
                        } elseif (strpos($status, 'setuju') !== false || strpos($status, 'approved') !== false) {
                            $st_key = 'approved';
                            $badge = '<span class="badge badge-approved">' . $badge_text . '</span>';
                        } elseif (strpos($status, 'tolak') !== false || strpos($status, 'rejected') !== false) {
                            $st_key = 'rejected';
                            $badge = '<span class="badge badge-rejected">' . $badge_text . '</span>';
                        } else {
                            // Fallback untuk status lain yang tidak dikenal
                            $st_key = 'unknown';
                            $badge = '<span class="badge badge-pending">' . $badge_text . '</span>';
                        }

                        $tgl_pengajuan = isset($s->tanggal_pengajuan) && $s->tanggal_pengajuan ? date('d M Y', strtotime($s->tanggal_pengajuan)) : '-';
                        $tgl_kegiatan = isset($s->tanggal_kegiatan) && $s->tanggal_kegiatan ? date('d M Y', strtotime($s->tanggal_kegiatan)) : '-';
                    ?>
                    <tr data-status="<?= $st_key ?>">
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($s->nama_kegiatan) ?></strong></td>
                        <td><?= htmlspecialchars($s->penyelenggara) ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan ?></td>
                        <td><?= htmlspecialchars($s->jenis_pengajuan) ?></td>
                        <td><?= $badge ?></td>
                        <td>
                            <div style="display:flex;gap:6px;flex-wrap:wrap">
                                <button class="btn btn-detail" onclick="showDetail(<?= $s->id ?>)" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <?php 
                                // ✅ Tombol approve/reject hanya untuk status "disetujui KK"
                                if($status == 'disetujui KK'): 
                                ?>
                                    <button class="btn btn-approve" onclick="approveSurat(<?= $s->id ?>)" title="Setujui & Teruskan ke Dekan">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                    <button class="btn btn-reject" onclick="showRejectModal(<?= $s->id ?>)" title="Tolak Pengajuan">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr id="emptyRow">
                        <td colspan="8" style="text-align:center;padding:40px;color:#7f8c8d">
                            <i class="fa-solid fa-inbox" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                            <strong>Belum ada pengajuan</strong>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="modal" onclick="modalClickOutside(event,'detailModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-alt"></i> Detail Pengajuan</h3>
            <button onclick="closeModal('detailModal')" style="background:none;border:0;font-size:20px;cursor:pointer">&times;</button>
        </div>
        <div id="detailContent"></div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal" onclick="modalClickOutside(event,'rejectModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-ban"></i> Tolak Pengajuan</h3>
            <button onclick="closeModal('rejectModal')" style="background:none;border:0;font-size:20px;cursor:pointer">&times;</button>
        </div>
        <div>
            <p style="margin-bottom:10px;color:#7f8c8d">Berikan alasan penolakan:</p>
            <textarea id="rejectionNotes" rows="5" placeholder="Masukkan alasan penolakan..." style="width:100%;padding:12px;border:2px solid #ddd;border-radius:8px;font-family:inherit;resize:vertical"></textarea>
            <div style="text-align:right;margin-top:12px">
                <button class="btn btn-reject" onclick="confirmReject()">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Penolakan
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const suratList = <?= isset($surat_list) && !empty($surat_list) ? json_encode($surat_list) : '[]' ?>;
let currentRejectId = null;

function updateTahun(year) {
    window.location.href = "<?= base_url('sekretariat?tahun=') ?>" + year;
}

function filterTable(status) {
    const rows = document.querySelectorAll('#tableBody tr:not(#emptyRow)');
    const filterInfo = document.getElementById('filterInfo');
    let visibleCount = 0;
    
    rows.forEach((row) => {
        const rowStatus = row.dataset.status;
        if (status === 'all' || rowStatus === status) {
            row.style.display = '';
            visibleCount++;
            row.querySelector('td:first-child').textContent = visibleCount;
        } else {
            row.style.display = 'none';
        }
    });
    
    const statusText = {
        'all': 'Semua Data', 
        'pending': 'Menunggu', 
        'approved': 'Disetujui', 
        'rejected': 'Ditolak',
        'completed': 'Selesai'
    };
    filterInfo.textContent = `Menampilkan: ${statusText[status]} (${visibleCount} data)`;
}

function showDetail(id) {
    // ✅ Ambil detail via AJAX untuk data yang lebih lengkap
    fetch(`<?= base_url('sekretariat/getDetailPengajuan/') ?>${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = data.data;
                
                // Format tanggal
                const formatDate = (dateStr) => {
                    if (!dateStr) return '-';
                    const date = new Date(dateStr);
                    return date.toLocaleDateString('id-ID', {day: '2-digit', month: 'long', year: 'numeric'});
                };
                
                // Format currency
                const formatCurrency = (amount) => {
                    if (!amount) return '-';
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(amount);
                };

                // Tampilkan status lengkap di modal
                const displayStatus = item.status || '-';
                
                const content = `
                    <div class="detail-row">
                        <div class="detail-label">Nama Kegiatan</div>
                        <div class="detail-value">${item.nama_kegiatan || '-'}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Penyelenggara</div>
                        <div class="detail-value">${item.penyelenggara || '-'}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Jenis Pengajuan</div>
                        <div class="detail-value">${item.jenis_pengajuan || '-'}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Tanggal Pengajuan</div>
                        <div class="detail-value">${formatDate(item.tanggal_pengajuan)}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Tanggal Kegiatan</div>
                        <div class="detail-value">${formatDate(item.tanggal_kegiatan)}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Status</div>
                        <div class="detail-value"><strong>${displayStatus}</strong></div>
                    </div>
                    ${item.deskripsi_kegiatan ? `
                    <div class="detail-row">
                        <div class="detail-label">Deskripsi Kegiatan</div>
                        <div class="detail-value">${item.deskripsi_kegiatan}</div>
                    </div>
                    ` : ''}
                    ${item.jumlah_peserta ? `
                    <div class="detail-row">
                        <div class="detail-label">Jumlah Peserta</div>
                        <div class="detail-value">${item.jumlah_peserta} orang</div>
                    </div>
                    ` : ''}
                    ${item.anggaran ? `
                    <div class="detail-row">
                        <div class="detail-label">Anggaran</div>
                        <div class="detail-value">${formatCurrency(item.anggaran)}</div>
                    </div>
                    ` : ''}
                    ${item.catatan_penolakan ? `
                    <div class="detail-row">
                        <div class="detail-label">Alasan Penolakan</div>
                        <div class="detail-value" style="color:#e74c3c">${item.catatan_penolakan}</div>
                    </div>
                    ` : ''}
                `;
                
                document.getElementById('detailContent').innerHTML = content;
                document.getElementById('detailModal').classList.add('show');
            } else {
                alert('Gagal memuat detail pengajuan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat data');
        });
}

function approveSurat(id) {
    if (!confirm('Apakah Anda yakin ingin menyetujui dan meneruskan pengajuan ini ke Dekan?')) return;
    window.location.href = '<?= base_url("sekretariat/approve/") ?>' + id;
}

function showRejectModal(id) {
    currentRejectId = id;
    document.getElementById('rejectionNotes').value = '';
    document.getElementById('rejectModal').classList.add('show');
}

function confirmReject() {
    const notes = document.getElementById('rejectionNotes').value.trim();
    if (!notes) { 
        alert('Alasan penolakan harus diisi'); 
        return; 
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= base_url("sekretariat/reject/") ?>' + currentRejectId;
    
    const csrfName = '<?= $this->security->get_csrf_token_name() ?>';
    const csrfHash = '<?= $this->security->get_csrf_hash() ?>';
    const inpCsrf = document.createElement('input');
    inpCsrf.type='hidden'; 
    inpCsrf.name=csrfName; 
    inpCsrf.value=csrfHash;
    form.appendChild(inpCsrf);
    
    const inpNotes = document.createElement('input');
    inpNotes.type='hidden'; 
    inpNotes.name='rejection_notes'; 
    inpNotes.value=notes;
    form.appendChild(inpNotes);
    
    document.body.appendChild(form);
    form.submit();
}

function closeModal(id) { 
    document.getElementById(id).classList.remove('show'); 
}

function modalClickOutside(evt, id) { 
    if (evt.target && evt.target.id === id) closeModal(id); 
}

// ✅ Grafik 3D - Data Hanya dari Sekretariat
const ctx = document.getElementById('grafikSurat').getContext('2d');
const fusionStyle3DPlugin = {
    id: 'fusionStyle3d',
    beforeDatasetsDraw: (chart) => {
        const ctx = chart.ctx;
        chart.data.datasets.forEach((dataset, datasetIndex) => {
            const meta = chart.getDatasetMeta(datasetIndex);
            if (!meta.hidden) {
                meta.data.forEach((bar) => {
                    const x = bar.x, y = bar.y, base = bar.base, width = bar.width, height = base - y;
                    if (height <= 1) return;
                    const offsetX = 15, offsetY = -15;
                    ctx.save();
                    
                    // Side gradient
                    const rightGradient = ctx.createLinearGradient(x + width/2, y, x + width/2 + offsetX, y + offsetY);
                    let darkColor = datasetIndex === 0 ? 'rgba(52, 152, 219, 0.7)' : 
                                   (datasetIndex === 1 ? 'rgba(46, 204, 113, 0.7)' : 'rgba(231, 76, 60, 0.7)');
                    rightGradient.addColorStop(0, darkColor);
                    rightGradient.addColorStop(1, 'rgba(0, 0, 0, 0.2)');
                    ctx.fillStyle = rightGradient;
                    ctx.beginPath();
                    ctx.moveTo(x + width/2, y);
                    ctx.lineTo(x + width/2 + offsetX, y + offsetY);
                    ctx.lineTo(x + width/2 + offsetX, base + offsetY);
                    ctx.lineTo(x + width/2, base);
                    ctx.closePath();
                    ctx.fill();
                    
                    // Top gradient
                    const topGradient = ctx.createLinearGradient(x - width/2, y, x + width/2 + offsetX, y + offsetY);
                    let lightColor = datasetIndex === 0 ? 'rgba(173, 216, 230, 0.95)' : 
                                    (datasetIndex === 1 ? 'rgba(200, 247, 197, 0.95)' : 'rgba(245, 183, 177, 0.95)');
                    topGradient.addColorStop(0, lightColor);
                    topGradient.addColorStop(1, 'rgba(255, 255, 255, 0.3)');
                    ctx.fillStyle = topGradient;
                    ctx.beginPath();
                    ctx.moveTo(x - width/2, y);
                    ctx.lineTo(x + width/2, y);
                    ctx.lineTo(x + width/2 + offsetX, y + offsetY);
                    ctx.lineTo(x - width/2 + offsetX, y + offsetY);
                    ctx.closePath();
                    ctx.fill();
                    ctx.restore();
                });
            }
        });
    }
};

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
        datasets: [
            {
                label: "Total", 
                data: <?= json_encode(isset($chart_total) ? $chart_total : array_fill(0,12,0)) ?>, 
                backgroundColor: 'rgba(52, 152, 219, 0.85)', 
                borderColor: 'rgba(52, 152, 219, 1)', 
                borderWidth: 2, 
                borderRadius: 6
            },
            {
                label: "Disetujui", 
                data: <?= json_encode(isset($chart_approved) ? $chart_approved : array_fill(0,12,0)) ?>, 
                backgroundColor: 'rgba(46, 204, 113, 0.85)', 
                borderColor: 'rgba(46, 204, 113, 1)', 
                borderWidth: 2, 
                borderRadius: 6
            },
            {
                label: "Ditolak", 
                data: <?= json_encode(isset($chart_rejected) ? $chart_rejected : array_fill(0,12,0)) ?>, 
                backgroundColor: 'rgba(231, 76, 60, 0.85)', 
                borderColor: 'rgba(231, 76, 60, 1)', 
                borderWidth: 2, 
                borderRadius: 6
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top', 
                labels: {
                    padding: 20, 
                    font: {size: 14, weight: '700'}, 
                    color: '#2c3e50'
                }
            }, 
            tooltip: {
                backgroundColor: 'rgba(44, 62, 80, 0.95)', 
                padding: 16,
                titleFont: {size: 14, weight: '700'},
                bodyFont: {size: 13}
            }
        },
        scales: {
            x: {
                grid: {display: false}, 
                ticks: {color: '#2c3e50', font: {size: 12, weight: '600'}}
            }, 
            y: {
                beginAtZero: true, 
                grid: {color: 'rgba(149, 165, 166, 0.15)'}, 
                ticks: {color: '#7f8c8d', font: {size: 12}}
            }
        },
        animation: {duration: 1800, easing: 'easeInOutQuart'}
    },
    plugins: [fusionStyle3DPlugin]
});
</script>
</body>
</html>