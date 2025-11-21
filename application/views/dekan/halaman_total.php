<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Total Pengajuan - Dashboard Dekan</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;}
    .navbar{background:#FB8C00;color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
    .navbar h2{font-size:20px;}
    .container{max-width:1200px;margin:30px auto;padding:0 20px;}
    
    /* Back Button */
    .back-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#FB8C00;color:white;text-decoration:none;border-radius:8px;font-weight:600;transition:all 0.3s;margin-bottom:20px}
    .back-btn:hover{background:#e67e22;transform:translateY(-2px)}
    
    /* Debug Info */
    .debug-info{background:#fff3cd;border-left:4px solid #ffc107;padding:15px;margin-bottom:15px;border-radius:4px;font-size:14px}
    
    /* Card Styles */
    .card{background:white;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,0.06);margin-bottom:20px}
    .card-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid #eee}
    
    /* Search and Filter */
    .search-filter-container{display:flex;align-items:center;gap:15px;margin-bottom:20px;flex-wrap:wrap;background:#f8f9fa;padding:15px;border-radius:10px;border:1px solid #e9ecef}
    .search-box{position:relative;flex:1;min-width:300px}
    .search-input{width:100%;padding:12px 45px 12px 15px;border:1px solid #ddd;border-radius:8px;font-size:14px;transition:all 0.3s;background:white}
    .search-input:focus{outline:none;border-color:#FB8C00;box-shadow:0 0 0 2px rgba(251,140,0,0.1)}
    .search-icon{position:absolute;right:15px;top:50%;transform:translateY(-50%);color:#6c757d}
    .filter-select{padding:12px 15px;border:1px solid #ddd;border-radius:8px;font-size:14px;background:white;color:#495057;min-width:180px;cursor:pointer;transition:all 0.3s}
    .filter-select:focus{outline:none;border-color:#FB8C00;box-shadow:0 0 0 2px rgba(251,140,0,0.1)}
    .btn-primary{padding:10px 20px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#FB8C00;color:#fff}
    .btn-primary:hover{background:#e67e22;transform:translateY(-2px)}
    .btn-secondary{padding:10px 20px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#95a5a6;color:#fff}
    .btn-secondary:hover{background:#7f8c8d}
    
    /* Table Styles */
    table{width:100%;border-collapse:collapse}
    thead{background:#f4f6f7}
    th,td{padding:12px;border-bottom:1px solid #ecf0f1;text-align:left;font-size:14px}
    tbody tr:hover{background:#fbfcfd}
    
    /* Badge Styles */
    .badge{display:inline-block;padding:6px 10px;border-radius:999px;font-weight:600;font-size:12px}
    .badge-pending{background:#fff3cd;color:#856404}
    .badge-approved{background:#d4edda;color:#155724}
    .badge-rejected{background:#f8d7da;color:#721c24}
    
    /* Button Styles */
    .btn{padding:6px 10px;border-radius:6px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s}
    .btn:hover{transform:scale(1.05)}
    .btn-approve{background:#27ae60;color:#fff}
    .btn-approve:hover{background:#229954}
    .btn-reject{background:#e74c3c;color:#fff}
    .btn-reject:hover{background:#c0392b}
    .btn-detail{background:#3498db;color:#fff}
    .btn-detail:hover{background:#2980b9}
    
    /* Pagination Info */
    .pagination-info{margin-top:15px;color:#7f8c8d;font-size:14px;text-align:right}
    
    /* Modal Styles */
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
    <h2><i class="fa-solid fa-university"></i> Dashboard Dekan</h2>
    <div></div>
</div>

<div class="container">
    <!-- Tombol Kembali -->
    <a href="<?= base_url('dekan') ?>" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
    </a>

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

    <!-- Debug Info -->
    <div class="debug-info">
        <strong>Debug Info:</strong> 
        Total Data: <?= isset($total_surat) ? $total_surat : '0' ?> | 
        Jumlah Data: <?= isset($surat_list) ? count($surat_list) : '0' ?> |
        Search: "<?= htmlspecialchars($this->input->get('search') ?? '') ?>" |
        Status: "<?= htmlspecialchars($this->input->get('status') ?? '') ?>"
    </div>

    <!-- Tabel Total Pengajuan -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Total Pengajuan Surat - Dekan</h3>
            <div>
                <span style="color:#7f8c8d;font-size:13px">
                    <?php
                    $filter_info = "Semua Data";
                    if($this->input->get('status') == 'pending') $filter_info = "Menunggu";
                    if($this->input->get('status') == 'approved') $filter_info = "Disetujui";
                    if($this->input->get('status') == 'rejected') $filter_info = "Ditolak";
                    echo "Menampilkan: " . $filter_info . " (" . (isset($total_surat) ? $total_surat : '0') . " data)";
                    ?>
                </span>
            </div>
        </div>
        
        <!-- Search + Filter -->
        <form method="get" action="<?= base_url('dekan/halaman_total') ?>">
            <div class="search-filter-container">
                <div class="search-box">
                    <input 
                        type="text" 
                        name="search" 
                        class="search-input"
                        placeholder="Cari nama kegiatan atau penyelenggara..."
                        value="<?= htmlspecialchars($this->input->get('search') ?? '') ?>"
                    >
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
                
                <select name="status" class="filter-select">
                    <option value="">Semua Status</option>
                    <option value="pending" <?= ($this->input->get('status') == 'pending') ? 'selected' : '' ?>>Menunggu</option>
                    <option value="approved" <?= ($this->input->get('status') == 'approved') ? 'selected' : '' ?>>Disetujui</option>
                    <option value="rejected" <?= ($this->input->get('status') == 'rejected') ? 'selected' : '' ?>>Ditolak</option>
                </select>
                
                <!-- Tambahkan input hidden untuk tahun -->
                <input type="hidden" name="tahun" value="<?= isset($tahun) ? $tahun : date('Y') ?>">
                
                <button type="submit" class="btn-primary" style="white-space:nowrap">
                    <i class="fa-solid fa-filter"></i> Terapkan
                </button>
                
                <a href="<?= base_url('dekan/halaman_total') ?>" class="btn-secondary" style="white-space:nowrap">
                    <i class="fa-solid fa-refresh"></i> Reset
                </a>
            </div>
        </form>
        
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
                    <?php 
                    if (isset($surat_list) && is_array($surat_list) && count($surat_list) > 0): 
                        $i = 1; 
                        foreach ($surat_list as $item): 
                            // Normalisasi status untuk dekan
                            $st_raw = isset($item['status']) ? trim($item['status']) : '';
                            $st_l = strtolower($st_raw);
                            
                            // Mapping status ke kategori
                            if ($st_l === 'disetujui sekretariat') {
                                $st_key = 'pending';
                                $badge = '<span class="badge badge-pending">Menunggu</span>';
                            } elseif ($st_l === 'disetujui dekan') {
                                $st_key = 'approved';
                                $badge = '<span class="badge badge-approved">Disetujui Dekan</span>';
                            } elseif ($st_l === 'ditolak dekan') {
                                $st_key = 'rejected';
                                $badge = '<span class="badge badge-rejected">Ditolak Dekan</span>';
                            } else {
                                $st_key = 'other';
                                $badge = '<span class="badge badge-pending">'.ucwords($st_raw).'</span>';
                            }
                            
                            // Format tanggal
                            $tgl_pengajuan = isset($item['tanggal_pengajuan']) && $item['tanggal_pengajuan'] ? date('d M Y', strtotime($item['tanggal_pengajuan'])) : '-';
                            $tgl_kegiatan = isset($item['tanggal_kegiatan']) && $item['tanggal_kegiatan'] ? date('d M Y', strtotime($item['tanggal_kegiatan'])) : '-';
                    ?>
                    <tr data-status="<?= $st_key ?>">
                        <td><?= $i ?></td>
                        <td><strong><?= htmlspecialchars($item['nama_kegiatan'] ?? '-') ?></strong></td>
                        <td><?= htmlspecialchars($item['penyelenggara'] ?? '-') ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan ?></td>
                        <td><?= htmlspecialchars($item['jenis_pengajuan'] ?? '-') ?></td>
                        <td><?= $badge ?></td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <button class="btn btn-detail" onclick="showDetail(<?= (int)$item['id'] ?>)" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <?php if ($st_l === 'disetujui sekretariat'): ?>
                                    <button class="btn btn-approve" onclick="approveSurat(<?= (int)$item['id'] ?>)" title="Setujui">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                    <button class="btn btn-reject" onclick="showRejectModal(<?= (int)$item['id'] ?>)" title="Tolak">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php $i++; endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align:center;padding:40px;color:#7f8c8d">
                                <i class="fa-solid fa-inbox" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                                <strong>
                                    <?php if($this->input->get('search') || $this->input->get('status')): ?>
                                        Tidak ada data yang sesuai dengan filter
                                    <?php else: ?>
                                        Belum ada pengajuan
                                    <?php endif; ?>
                                </strong>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-info">
            <?php
            $filter_info = "Semua Data";
            if($this->input->get('status') == 'pending') $filter_info = "Menunggu";
            if($this->input->get('status') == 'approved') $filter_info = "Disetujui";
            if($this->input->get('status') == 'rejected') $filter_info = "Ditolak";
            echo "Menampilkan: " . $filter_info . " (" . (isset($total_surat) ? $total_surat : '0') . " data)";
            ?>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-alt"></i> Detail Pengajuan</h3>
            <button onclick="closeModal('detailModal')" style="background:none;border:0;font-size:20px;cursor:pointer">&times;</button>
        </div>
        <div id="detailContent"></div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal">
    <div class="modal-content">
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

<script>
// Data dari controller
const suratList = <?= isset($surat_list) ? json_encode($surat_list) : '[]' ?>;
let currentRejectId = null;

// Detail functions
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
            <div class="detail-row"><div class="detail-label">File Eviden:</div><div class="detail-value">${getVal('eviden') ? '<a href="<?= base_url('uploads/') ?>'+escapeHtml(getVal('eviden'))+'" target="_blank" style="color:#3498db"><i class="fa-solid fa-paperclip"></i> '+escapeHtml(getVal('eviden'))+'</a>' : '-'}</div></div>
            ${getVal('catatan_penolakan') && getVal('catatan_penolakan') !== '-' ? '<div class="detail-row"><div class="detail-label">Catatan Penolakan:</div><div class="detail-value" style="color:#e74c3c">'+escapeHtml(getVal('catatan_penolakan'))+'</div></div>' : ''}
            <div style="text-align:right;margin-top:20px;padding-top:15px;border-top:1px solid #eee">
                ${ (item.status && item.status.toLowerCase() === 'disetujui sekretariat') ? 
                    `<button class="btn btn-approve" onclick="approveSurat(${item.id}); closeModal('detailModal')" style="margin-right:8px">
                        <i class="fa-solid fa-check"></i> Setujui
                    </button>
                    <button class="btn btn-reject" onclick="showRejectModal(${item.id}); closeModal('detailModal')">
                        <i class="fa-solid fa-times"></i> Tolak
                    </button>` : '' }
            </div>
        </div>
    `;
    document.getElementById('detailContent').innerHTML = content;
    document.getElementById('detailModal').classList.add('show');
}

function approveSurat(id) {
    if (!confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')) return;
    
    // Build URL dengan parameter filter yang aktif
    const searchParams = new URLSearchParams(window.location.search);
    const from = 'total';
    const tahun = searchParams.get('tahun') || '<?= date("Y") ?>';
    
    window.location.href = `<?= base_url("dekan/approve/") ?>${id}?from=${from}&tahun=${tahun}&${searchParams.toString()}`;
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
    
    // Build URL dengan parameter filter yang aktif
    const searchParams = new URLSearchParams(window.location.search);
    const from = 'total';
    const tahun = searchParams.get('tahun') || '<?= date("Y") ?>';
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `<?= base_url("dekan/reject/") ?>${currentRejectId}?from=${from}&tahun=${tahun}&${searchParams.toString()}`;

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

function formatDate(d) {
    if (!d || d === '-') return '-';
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
       .replace(/"/g, "&quot;")
       .replace(/'/g, "&#039;");
}

// Close modal ketika klik di luar
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal')) {
        e.target.classList.remove('show');
    }
});

// Auto submit form ketika select berubah
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.querySelector('select[name="status"]');
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
});
</script>
</body>
</html>