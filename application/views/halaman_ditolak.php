<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengajuan Ditolak - Dashboard Kaprodi</title>
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
    .badge-rejected{background:#f8d7da;color:#721c24}
    .btn{padding:6px 10px;border-radius:6px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s}
    .btn:hover{transform:scale(1.05)}
    .btn-detail{background:#3498db;color:#fff}
    .btn-detail:hover{background:#2980b9}
    .pagination-info{margin-top:15px;color:#7f8c8d;font-size:14px;text-align:right}
    .back-btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#3498db;color:white;text-decoration:none;border-radius:8px;font-weight:600;transition:all 0.3s;margin-bottom:20px}
    .back-btn:hover{background:#2980b9;transform:translateY(-2px)}
    .status-header{display:flex;align-items:center;gap:15px;margin-bottom:20px;padding:20px;background:white;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06)}
    .status-icon{width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:24px}
    .status-icon.rejected{background:#f8d7da;color:#e74c3c}
    .status-info h1{margin:0;color:#2c3e50;font-size:28px}
    .status-info p{margin:5px 0 0 0;color:#7f8c8d;font-size:16px}
    .modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.45);align-items:center;justify-content:center}
    .modal.show{display:flex}
    .modal-content{background:white;padding:20px;border-radius:10px;max-width:800px;width:95%;max-height:85vh;overflow:auto;animation:slideIn 0.3s ease}
    @keyframes slideIn{from{transform:translateY(-50px);opacity:0}to{transform:translateY(0);opacity:1}}
    .modal-header{display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #eee;padding-bottom:10px;margin-bottom:10px}
    .detail-row{display:grid;grid-template-columns:200px 1fr;padding:8px 0;border-bottom:1px solid #f4f6f7}
    .detail-label{font-weight:700;color:#7f8c8d}
    .detail-value{color:#2c3e50}
    /* Search Box Styles */
    .search-container{margin-bottom:20px}
    .search-label{display:block;margin-bottom:8px;color:#6c757d;font-size:14px;font-weight:500}
    .search-box{display:flex;gap:10px;align-items:center;width:100%}
    .search-input-wrapper{position:relative;flex:1}
    .search-input{width:100%;padding:12px 45px 12px 15px;border:1px solid #e9ecef;border-radius:8px;font-size:14px;transition:all 0.3s;background:white;color:#495057}
    .search-input:focus{outline:none;border-color:#8E44AD;box-shadow:0 0 0 2px rgba(142,68,173,0.1)}
    .search-input::placeholder{color:#6c757d}
    .search-icon{position:absolute;right:15px;top:50%;transform:translateY(-50%);color:#6c757d;font-size:16px}
    .btn-cari{padding:12px 24px;border-radius:8px;border:0;cursor:pointer;font-weight:600;transition:all 0.2s;display:inline-flex;align-items:center;gap:8px;background:#6c757d;color:#fff;white-space:nowrap}
    .btn-cari:hover{background:#5a6268;transform:translateY(-1px)}
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

    <!-- Header Status -->
    <div class="status-header">
        <div class="status-icon rejected">
            <i class="fa-solid fa-times"></i>
        </div>
        <div class="status-info">
            <h1>DITOLAK</h1>
            <p><?= isset($total_surat) ? $total_surat : '0' ?> Pengajuan</p>
        </div>
    </div>

    <?php if($this->session->flashdata('success')): ?>
    <div class="card" style="border-left:4px solid #27ae60;margin-bottom:18px">
        <div style="color:#155724;font-weight:700"><?php echo $this->session->flashdata('success'); ?></div>
    </div>
    <?php endif; ?>

    <!-- Tabel Pengajuan Ditolak -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fa-solid fa-table"></i> Daftar Pengajuan Ditolak</h3>
        </div>
        
        <!-- Search Box -->
        <div class="search-container">
            <label class="search-label">Cari berdasarkan nama kegiatan, penyelenggara, atau jenis pengajuan...</label>
            <div class="search-box">
                <div class="search-input-wrapper">
                    <input 
                        type="text" 
                        id="searchInput"
                        class="search-input"
                        placeholder="Ketik untuk mencari..."
                    >
                    <div class="search-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
                <button type="button" class="btn-cari" onclick="handleSearch()">
                    <i class="fa-solid fa-search"></i> Cari
                </button>
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
                    <?php 
                    if(isset($surat_list) && is_array($surat_list) && !empty($surat_list)): 
                        $no = 1; 
                        foreach($surat_list as $s): 
                            $tgl_pengajuan = isset($s->created_at) && $s->created_at ? date('d M Y', strtotime($s->created_at)) : '-';
                            
                            // Format tanggal kegiatan - handle range tanggal
                            $tgl_kegiatan = '-';
                            if (isset($s->tanggal_kegiatan) && $s->tanggal_kegiatan) {
                                $tgl_kegiatan = date('d M Y', strtotime($s->tanggal_kegiatan));
                                if (isset($s->akhir_kegiatan) && $s->akhir_kegiatan && $s->akhir_kegiatan !== '-' && $s->akhir_kegiatan !== $s->tanggal_kegiatan) {
                                    $tgl_kegiatan .= ' - ' . date('d M Y', strtotime($s->akhir_kegiatan));
                                }
                            }
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($s->nama_kegiatan ?? '-') ?></strong></td>
                        <td><?= htmlspecialchars($s->penyelenggara ?? '-') ?></td>
                        <td><?= $tgl_pengajuan ?></td>
                        <td><?= $tgl_kegiatan ?></td>
                        <td><?= htmlspecialchars($s->jenis_pengajuan ?? '-') ?></td>
                        <td>
                            <span class="badge badge-rejected">
                                <?= 
                                    isset($s->status) ? 
                                    (strpos(strtolower($s->status), 'ditolak') !== false ? 
                                        ucwords($s->status) : 
                                        'Ditolak') : 
                                    'Ditolak' 
                                ?>
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <button class="btn btn-detail" onclick="showDetail(<?= $s->id ?? 0 ?>)" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="8" style="text-align:center;padding:40px;color:#7f8c8d">
                            <i class="fa-solid fa-times-circle" style="font-size:48px;margin-bottom:10px;display:block;opacity:0.3"></i>
                            <strong>
                                <?php if(!isset($surat_list)): ?>
                                    Variabel $surat_list tidak terdefinisi
                                <?php elseif(empty($surat_list)): ?>
                                    Tidak ada pengajuan yang ditolak
                                <?php else: ?>
                                    Data tidak valid
                                <?php endif; ?>
                            </strong>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-info">
            Menampilkan: Pengajuan Ditolak (<?= isset($total_surat) ? $total_surat : '0' ?> data)
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

<script>
const suratList = <?= isset($surat_list) && !empty($surat_list) ? json_encode($surat_list) : '[]' ?>;
let currentSearchTerm = '';

function showDetail(id) {
    const item = suratList.find(s => Number(s.id) === Number(id));
    if (!item) { 
        alert('Data tidak ditemukan'); 
        return; 
    }
    
    // Format tanggal untuk modal
    const formatDate = (dateString) => {
        if (!dateString || dateString === '-') return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', { 
            day: 'numeric', 
            month: 'long', 
            year: 'numeric' 
        });
    };
    
    const content = `
        <div>
            <div class="detail-row">
                <div class="detail-label">Nama Kegiatan:</div>
                <div class="detail-value">${item.nama_kegiatan || '-'}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Penyelenggara:</div>
                <div class="detail-value">${item.penyelenggara || '-'}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Jenis Pengajuan:</div>
                <div class="detail-value">${item.jenis_pengajuan || '-'}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Tanggal Pengajuan:</div>
                <div class="detail-value">${formatDate(item.created_at)}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Tanggal Kegiatan:</div>
                <div class="detail-value">${formatDate(item.tanggal_kegiatan)}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Tempat Kegiatan:</div>
                <div class="detail-value">${item.tempat_kegiatan || '-'}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Status:</div>
                <div class="detail-value">${item.status || 'Ditolak'}</div>
            </div>
            ${item.catatan_penolakan ? `
            <div class="detail-row">
                <div class="detail-label">Alasan Penolakan:</div>
                <div class="detail-value" style="color:#e74c3c;font-weight:500">${item.catatan_penolakan}</div>
            </div>
            ` : ''}
        </div>`;
    document.getElementById('detailContent').innerHTML = content;
    document.getElementById('detailModal').classList.add('show');
}

function closeModal(id) { 
    document.getElementById(id).classList.remove('show'); 
}

// Search functionality
function handleSearch() {
    const searchInput = document.getElementById('searchInput');
    const searchTerm = searchInput.value.toLowerCase();
    currentSearchTerm = searchTerm;
    
    const rows = document.querySelectorAll('#tableBody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update pagination info
    updatePaginationInfo(visibleCount, searchTerm);
}

function updatePaginationInfo(visibleCount, searchTerm) {
    const paginationInfo = document.querySelector('.pagination-info');
    if (paginationInfo) {
        if (searchTerm) {
            paginationInfo.textContent = `Menampilkan: ${visibleCount} data (difilter)`;
        } else {
            paginationInfo.textContent = `Menampilkan: Pengajuan Ditolak (${visibleCount} data)`;
        }
    }
}

// Enter key support for search
document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        handleSearch();
    }
});

// Auto reset when input is cleared
document.getElementById('searchInput').addEventListener('input', function(e) {
    if (e.target.value === '') {
        const rows = document.querySelectorAll('#tableBody tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            row.style.display = '';
            visibleCount++;
        });
        
        updatePaginationInfo(visibleCount, '');
    }
});

// Close modal ketika klik di luar
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal')) {
        e.target.classList.remove('show');
    }
});
</script>
</body>
</html>