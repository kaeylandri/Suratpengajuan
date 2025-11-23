<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Total Pengajuan - Dashboard Kaprodi</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;background:#f5f7fa;}
    .navbar{background:#8E44AD;color:white;padding:15px 30px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 4px rgba(0,0,0,0.1);}
    .navbar h2{font-size:20px;}
    .container{max-width:1200px;margin:30px auto;padding:0 20px;}
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
    .btn{padding:6px 10px;border-radius:6px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s}
    .btn:hover{transform:scale(1.05)}
    .btn-approve{background:#27ae60;color:#fff}
    .btn-approve:hover{background:#229954}
    .btn-reject{background:#e74c3c;color:#fff}
    .btn-reject:hover{background:#c0392b}
    .btn-detail{background:#3498db;color:#fff}
    .btn-detail:hover{background:#2980b9}
    .search-filter-container{display:flex;align-items:center;gap:15px;margin-bottom:20px;flex-wrap:wrap;background:#f8f9fa;padding:15px;border-radius:10px;border:1px solid #e9ecef}
    .search-box{position:relative;flex:1;min-width:300px}
    .search-input{width:100%;padding:12px 45px 12px 15px;border:1px solid #ddd;border-radius:8px;font-size:14px;transition:all 0.3s;background:white}
    .search-input:focus{outline:none;border-color:#8E44AD;box-shadow:0 0 0 2px rgba(142,68,173,0.1)}
    .search-icon{position:absolute;right:15px;top:50%;transform:translateY(-50%);color:#6c757d}
    .filter-select{padding:12px 15px;border:1px solid #ddd;border-radius:8px;font-size:14px;background:white;color:#495057;min-width:180px;cursor:pointer;transition:all 0.3s}
    .filter-select:focus{outline:none;border-color:#8E44AD;box-shadow:0 0 0 2px rgba(142,68,173,0.1)}
    .btn-primary{padding:10px 20px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#8E44AD;color:#fff;text-decoration:none}
    .btn-primary:hover{background:#7d3c98;transform:translateY(-2px)}
    .btn-secondary{padding:10px 20px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#95a5a6;color:#fff;text-decoration:none}
    .btn-secondary:hover{background:#7f8c8d}
    .pagination-info{margin-top:15px;color:#7f8c8d;font-size:14px;text-align:right}
    .back-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#3498db;color:white;text-decoration:none;border-radius:8px;font-weight:600;transition:all 0.3s;margin-bottom:20px}
    .back-btn:hover{background:#2980b9;transform:translateY(-2px)}
    
    /* Modal Styles */
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.45);align-items:center;justify-content:center}
    .modal.show{display:flex}
    .modal-content{background:white;padding:0;border-radius:15px;max-width:800px;width:95%;max-height:85vh;overflow:hidden;animation:slideIn 0.3s ease;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
    @keyframes slideIn{from{transform:translateY(-50px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-header{background:#8E44AD;color:white;padding:20px 25px;display:flex;justify-content:space-between;align-items:center;border-radius:15px 15px 0 0}
    .modal-header h3{margin:0;font-size:18px;font-weight:600}
    .close-modal{background:none;border:0;color:white;font-size:24px;cursor:pointer;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:50%;transition:background 0.2s}
    .close-modal:hover{background:rgba(255,255,255,0.2)}
    
    /* Detail Content Styles */
    .detail-content{padding:25px;max-height:calc(85vh - 80px);overflow-y:auto}
    .detail-section{margin-bottom:25px;background:#f8f9fa;border-radius:12px;padding:20px;border:1px solid #e9ecef}
    .detail-section:last-child{margin-bottom:0}
    .detail-section-title{font-size:16px;font-weight:700;color:#8E44AD;margin-bottom:15px;padding-bottom:10px;border-bottom:2px solid #8E44AD;display:flex;align-items:center;gap:10px}
    .detail-section-title i{font-size:18px}
    .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:15px}
    .detail-row{display:flex;flex-direction:column;margin-bottom:12px}
    .detail-label{font-weight:600;color:#495057;font-size:13px;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.5px}
    .detail-value{color:#212529;font-size:14px;background:white;padding:10px 15px;border-radius:8px;border:1px solid #e9ecef;min-height:40px;display:flex;align-items:center}
    
    /* Responsive */
    @media (max-width:768px){
        .detail-grid{grid-template-columns:1fr}
        .modal-content{width:95%;margin:10px}
        .detail-content{padding:15px}
        .search-filter-container{flex-direction:column}
        .search-box{width:100%;min-width:100%}
        .filter-select{width:100%}
    }
</style>
</head>
<body>

<div class="navbar">
    <h2><i class="fa-solid fa-user-tie"></i> Dashboard Kaprodi</h2>
    <div></div>
</div>

<div class="container">
    <!-- Tombol Kembali -->
    <a href="<?= base_url('kaprodi') ?>" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
    </a>

    <?php if($this->session->flashdata('success')): ?>
    <div class="card" style="border-left:4px solid #27ae60;margin-bottom:18px">
        <div style="color:#155724;font-weight:700"><?php echo $this->session->flashdata('success'); ?></div>
    </div>
    <?php endif; ?>

    <!-- Tabel Total Pengajuan -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Total Pengajuan Surat</h3>
            <div>
                <span style="color:#7f8c8d;font-size:13px">
                    Total: <?= isset($total_surat) ? $total_surat : '0' ?> data
                </span>
            </div>
        </div>
        
        <!-- Search + Filter -->
        <div class="search-filter-container">
            <div class="search-box">
                <input 
                    type="text" 
                    id="searchInput"
                    class="search-input"
                    placeholder="Cari berdasarkan nama kegiatan, penyelenggara, atau jenis pengajuan..."
                    value=""
                    autocomplete="off"
                >
                <div class="search-icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>
            
            <select id="statusSelect" class="filter-select">
                <option value="">Semua Status</option>
                <option value="pending">Menunggu</option>
                <option value="approved">Disetujui</option>
                <option value="rejected">Ditolak</option>
            </select>
            
            <button type="button" onclick="resetFilter()" class="btn-secondary">
                <i class="fa-solid fa-refresh"></i> Reset
            </button>
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
                    <?php 
                    if(isset($surat_list) && is_array($surat_list) && !empty($surat_list)): 
                        $no = 1; 
                        foreach($surat_list as $s): 
                            $st_l = strtolower($s->status ?? '');
                            
                            // Tentukan warna berdasarkan kata kunci
                            if (strpos($st_l, 'setuju') !== false || strpos($st_l, 'disetujui') !== false) {
                                $st_key = 'approved';
                                $badge = '<span class="badge badge-approved">'.ucwords($s->status ?? '').'</span>';
                            } elseif (strpos($st_l, 'tolak') !== false || strpos($st_l, 'ditolak') !== false) {
                                $st_key = 'rejected';
                                $badge = '<span class="badge badge-rejected">'.ucwords($s->status ?? '').'</span>';
                            } else {
                                $st_key = 'pending';
                                $badge = '<span class="badge badge-pending">'.ucwords($s->status ?? '').'</span>';
                            }

                            $tgl_pengajuan = isset($s->created_at) && $s->created_at? date('d M Y', strtotime($s->created_at)) : '-';
                            $tgl_kegiatan = isset($s->tanggal_kegiatan) && $s->tanggal_kegiatan ? date('d M Y', strtotime($s->tanggal_kegiatan)) : '-';
                    ?>
                    <tr data-status="<?= $st_key ?>" data-nama="<?= strtolower(htmlspecialchars($s->nama_kegiatan ?? '')) ?>" data-penyelenggara="<?= strtolower(htmlspecialchars($s->penyelenggara ?? '')) ?>" data-jenis="<?= strtolower(htmlspecialchars($s->jenis_pengajuan ?? '')) ?>">
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($s->nama_kegiatan ?? '-') ?></strong></td>
                        <td><?= htmlspecialchars($s->penyelenggara ?? '-') ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan ?></td>
                        <td><?= htmlspecialchars($s->jenis_pengajuan ?? '-') ?></td>
                        <td><?= $badge ?></td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <button class="btn btn-detail" onclick="showDetail(<?= $s->id ?? 0 ?>)" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <?php if(($s->status ?? '') == 'pengajuan'): ?>
                                    <button class="btn btn-approve" onclick="approveSurat(<?= $s->id ?? 0 ?>)" title="Setujui">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                    <button class="btn btn-reject" onclick="showRejectModal(<?= $s->id ?? 0 ?>)" title="Tolak">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="8" style="text-align:center;padding:40px;color:#7f8c8d">
                            <i class="fa-solid fa-inbox" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                            <strong>Tidak ada data pengajuan</strong>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-info" id="paginationInfo">
            Menampilkan: Semua Data (<?= isset($total_surat) ? $total_surat : '0' ?> data)
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="modal" onclick="modalClickOutside(event,'detailModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-file-alt"></i> Detail Pengajuan Surat Tugas</h3>
            <button class="close-modal" onclick="closeModal('detailModal')">&times;</button>
        </div>
        <div class="detail-content" id="detailContent">
            <!-- Content akan diisi oleh JavaScript -->
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal" onclick="modalClickOutside(event,'rejectModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fa-solid fa-ban"></i> Tolak Pengajuan</h3>
            <button class="close-modal" onclick="closeModal('rejectModal')">&times;</button>
        </div>
        <div style="padding:25px">
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
const suratList = <?= isset($surat_list) && !empty($surat_list) ? json_encode($surat_list) : '[]' ?>;
let currentRejectId = null;
let allRows = [];

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    allRows = Array.from(document.querySelectorAll('#tableBody tr[data-status]'));
    
    const searchInput = document.getElementById('searchInput');
    const statusSelect = document.getElementById('statusSelect');
    
    // Search input dengan debounce
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(filterTable, 300);
    });
    
    // Status filter
    statusSelect.addEventListener('change', filterTable);
});

function filterTable() {
    const searchValue = document.getElementById('searchInput').value.toLowerCase().trim();
    const statusValue = document.getElementById('statusSelect').value;
    
    let visibleCount = 0;
    let rowNumber = 1;
    
    allRows.forEach(row => {
        const rowStatus = row.getAttribute('data-status');
        const rowNama = row.getAttribute('data-nama');
        const rowPenyelenggara = row.getAttribute('data-penyelenggara');
        const rowJenis = row.getAttribute('data-jenis');
        
        // Check status filter
        const statusMatch = !statusValue || rowStatus === statusValue;
        
        // Check search filter
        const searchMatch = !searchValue || 
            rowNama.includes(searchValue) || 
            rowPenyelenggara.includes(searchValue) || 
            rowJenis.includes(searchValue);
        
        if (statusMatch && searchMatch) {
            row.style.display = '';
            row.cells[0].textContent = rowNumber++;
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update pagination info
    updatePaginationInfo(visibleCount, searchValue, statusValue);
    
    // Show/hide empty message
    showEmptyMessage(visibleCount === 0);
}

function updatePaginationInfo(count, search, status) {
    let filterInfo = 'Semua Data';
    if (status === 'pending') filterInfo = 'Menunggu';
    if (status === 'approved') filterInfo = 'Disetujui';
    if (status === 'rejected') filterInfo = 'Ditolak';
    
    let searchInfo = search ? ` (Hasil pencarian: "${search}")` : '';
    
    document.getElementById('paginationInfo').textContent = 
        `Menampilkan: ${filterInfo} (${count} data)${searchInfo}`;
}

function showEmptyMessage(show) {
    const tbody = document.getElementById('tableBody');
    let emptyRow = tbody.querySelector('.empty-message-row');
    
    if (show && !emptyRow) {
        emptyRow = tbody.insertRow(0);
        emptyRow.className = 'empty-message-row';
        const cell = emptyRow.insertCell(0);
        cell.colSpan = 8;
        cell.style.textAlign = 'center';
        cell.style.padding = '40px';
        cell.style.color = '#7f8c8d';
        cell.innerHTML = '<i class="fa-solid fa-inbox" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i><strong>Tidak ada data yang sesuai dengan filter</strong>';
    } else if (!show && emptyRow) {
        emptyRow.remove();
    }
}

function resetFilter() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusSelect').value = '';
    filterTable();
}

// Modal functions
function showDetail(id) {
    const item = suratList.find(s => Number(s.id) === Number(id));
    if (!item) { 
        alert('Data tidak ditemukan'); 
        return; 
    }
    
    const formatDate = (dateStr) => {
        if (!dateStr || dateStr === '-' || dateStr === '0000-00-00') return '-';
        const date = new Date(dateStr);
        return date.toLocaleDateString('id-ID', { 
            day: '2-digit', 
            month: 'short', 
            year: 'numeric' 
        });
    };
    
    const escapeHtml = (unsafe) => {
        if (unsafe === null || unsafe === undefined) return '-';
        return String(unsafe)
           .replace(/&/g, "&amp;")
           .replace(/</g, "&lt;")
           .replace(/>/g, "&gt;")
           .replace(/"/g, "&quot;")
           .replace(/'/g, "&#039;");
    };
    
    const getVal = (k) => (item[k] !== undefined && item[k] !== null ? item[k] : '-');
    
    const status = getVal('status');
    let statusBadge = '';
    if (status.toLowerCase().includes('ditolak')) {
        statusBadge = '<span class="badge badge-rejected" style="margin-left:10px">Ditolak</span>';
    } else if (status.toLowerCase().includes('disetujui')) {
        statusBadge = '<span class="badge badge-approved" style="margin-left:10px">Disetujui</span>';
    } else {
        statusBadge = '<span class="badge badge-pending" style="margin-left:10px">Menunggu</span>';
    }

    const content = `
        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-info-circle"></i> Informasi Utama
            </div>
            <div class="detail-grid">
                <div class="detail-row">
                    <div class="detail-label">NAMA KEGIATAN</div>
                    <div class="detail-value">${escapeHtml(getVal('nama_kegiatan'))}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">JENIS PENGAJUAN</div>
                    <div class="detail-value">${escapeHtml(getVal('jenis_pengajuan'))}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">STATUS PENGAJUAN</div>
                    <div class="detail-value" style="display:flex;align-items:center">
                        ${escapeHtml(status)} ${statusBadge}
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">NIP</div>
                    <div class="detail-value">${escapeHtml(getVal('nip'))}</div>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-section-title">
                <i class="fa-solid fa-calendar-alt"></i> Informasi Waktu & Tempat
            </div>
            <div class="detail-grid">
                <div class="detail-row">
                    <div class="detail-label">TANGGAL PENGAJUAN</div>
                    <div class="detail-value">${formatDate(getVal('created_at'))}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">TANGGAL KEGIATAN</div>
                    <div class="detail-value">${formatDate(getVal('tanggal_kegiatan'))}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">PENYELENGGARA</div>
                    <div class="detail-value">${escapeHtml(getVal('penyelenggara'))}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">TEMPAT KEGIATAN</div>
                    <div class="detail-value">${escapeHtml(getVal('tempat_kegiatan') || '-')}</div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('detailContent').innerHTML = content;
    document.getElementById('detailModal').classList.add('show');
}

function showRejectModal(id) {
    currentRejectId = id;
    document.getElementById('rejectionNotes').value = '';
    document.getElementById('rejectModal').classList.add('show');
}

function approveSurat(id) {
    if (!confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')) return;
    window.location.href = '<?= base_url("kaprodi/approve/") ?>' + id;
}

function confirmReject() {
    const notes = document.getElementById('rejectionNotes').value.trim();
    if (!notes) { 
        alert('Alasan penolakan harus diisi'); 
        return; 
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= base_url("kaprodi/reject/") ?>' + currentRejectId;
    
    const inpNotes = document.createElement('input');
    inpNotes.type='hidden'; inpNotes.name='rejection_notes'; inpNotes.value=notes;
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
</script>
</body>
</html>