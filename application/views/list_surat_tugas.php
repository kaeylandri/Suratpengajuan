<!DOCTYPE html>
<html lang="en-id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Table Surat Tugas</title>
    
    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    
    <style>
        /* ===== VARIABLES & BASE STYLES ===== */
        :root {
            --primary-color: #FB8C00;
            --primary-hover: #e67e00;
            --bg-color: #f6f9fb;
            --card-bg: #ffffff;
            --text-primary: #333;
            --text-secondary: #666;
            --border-color: #f0f0f0;
            --shadow: 0 4px 14px rgba(0,0,0,0.06);
            --radius: 12px;
        }

        * {
            box-sizing: border-box;
        }

        body, input, select, button, table {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--bg-color);
        }

        /* ===== LAYOUT COMPONENTS ===== */
        .container-main {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 25px;
            text-align: center;
        }

        /* ===== FILTER COMPONENTS ===== */
        .filter-bar {
            width: 100%;
            background: var(--card-bg);
            padding: 12px 14px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 14px;
            border: 1px solid var(--border-color);
            flex-wrap: wrap;
        }

        .filter-search {
            flex: 1 1 360px;
            min-width: 220px;
            display: flex;
            position: relative;
        }

        .filter-search input {
            width: 100%;
            padding: 10px 40px 10px 14px;
            height: 44px;
            border-radius: 10px;
            border: 1.5px solid var(--primary-color);
            outline: none;
            font-size: 14px;
        }

        .filter-search i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            pointer-events: none;
        }

        .filter-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-small {
            height: 44px;
            min-width: 44px;
            border-radius: 10px;
            border: 1.5px solid var(--primary-color);
            padding: 0 12px;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: white;
            transition: all 0.3s ease;
        }

        .btn-add {
            background: var(--primary-color);
            color: white;
        }

        .btn-add:hover {
            background: var(--primary-hover);
        }

        .btn-reset {
            background: var(--primary-color);
            color: white;
            border: 1.5px solid var(--primary-color);
            border-radius: 10px;
            padding: 0 14px;
            height: 44px;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .btn-reset:hover {
            background: var(--primary-hover);
        }

        .btn-reset[hidden] {
            display: none;
        }

        /* ===== FILTER BUILDER ===== */
        .filter-builder {
            display: flex;
            gap: 10px;
            align-items: center;
            width: 100%;
            flex-wrap: wrap;
            margin-bottom: 14px;
        }

        .filter-row {
            width: 100%;
            background: var(--card-bg);
            padding: 12px 14px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            display: flex;
            gap: 12px;
            align-items: center;
            border: 1px solid var(--border-color);
            flex-wrap: wrap;
        }

        .filter-row .row-search-wrapper {
            flex: 1 1 360px;
            min-width: 220px;
            display: flex;
            position: relative;
        }

        .filter-row .row-search {
            width: 100%;
            padding: 10px 40px 10px 14px;
            height: 44px;
            border-radius: 10px;
            border: 1.5px solid var(--primary-color);
            outline: none;
            font-size: 14px;
            background: white;
        }

        .filter-row .row-search-wrapper i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            pointer-events: none;
        }

        .filter-row select.row-cat {
            height: 44px;
            min-width: 44px;
            border-radius: 10px;
            border: 1.5px solid var(--primary-color);
            padding: 0 14px;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: white;
            outline: none;
        }

        .filter-row input[type="date"] {
            height: 44px;
            padding: 0 14px;
            border-radius: 10px;
            border: 1.5px solid var(--primary-color);
            background: white;
            font-size: 14px;
            min-width: 160px;
            outline: none;
        }

        .filter-row .row-btn {
            height: 44px;
            min-width: 44px;
            border-radius: 10px;
            border: 1.5px solid var(--primary-color);
            padding: 0 14px;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: white;
            transition: all 0.3s ease;
        }

        .filter-row .row-btn.add {
            background: var(--primary-color);
            color: #fff;
        }

        .filter-row .row-btn.add:hover {
            background: var(--primary-hover);
        }

        .filter-row .row-btn.remove {
            background: var(--primary-color);
            color: white;
        }

        .filter-row .row-btn.remove:hover {
            background: var(--primary-hover);
        }

        /* ===== TABLE STYLES ===== */
        #tabelSurat {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        #tabelSurat thead {
            background: var(--primary-color);
            color: white;
        }

        #tabelSurat td, #tabelSurat th {
            padding: 12px;
            border: 1px solid #eee;
            vertical-align: middle;
        }

        #tabelSurat td:nth-child(4),
        #tabelSurat td:nth-child(5) {
            min-width: 180px;
            max-width: 280px;
        }

        #tabelSurat tbody tr.row-detail {
            cursor: pointer;
            transition: background 0.2s;
        }

        #tabelSurat tbody tr.row-detail:hover {
            background: #fffaf5;
        }

        /* ===== BADGE STYLES ===== */
        .dosen-container, .divisi-container {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            align-items: center;
        }

        .nama-dosen-badge {
            display: inline-block;
            background: #fff4e6;
            color: #663c00;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            border: 1px solid var(--primary-color);
            white-space: nowrap;
            max-width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nama-dosen-more {
            display: inline-block;
            background: var(--primary-color);
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .nama-dosen-more:hover {
            transform: scale(1.03);
            background: var(--primary-hover);
        }

        .divisi-badge {
            display: inline-block;
            background: #e3f2fd;
            color: #0d47a1;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            border: 1px solid #2196F3;
            white-space: nowrap;
        }

        /* ===== BUTTON STYLES ===== */
        .btn {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            display: inline-block;
            margin: 0 2px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-warning {
            background: #ffa726;
            color: white;
        }

        .btn-warning:hover {
            background: #fb8c00;
        }

        .btn-danger {
            background: #ef5350;
            color: white;
        }

        .btn-danger:hover {
            background: #e53935;
        }

        .btn-info {
            background: #29b6f6;
            color: white;
        }

        .btn-info:hover {
            background: #0288d1;
        }

        /* ===== MODAL STYLES ===== */
        .modal-detail {
            display: none !important;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            padding-top: 40px;
        }

        .modal-detail.show {
            display: flex !important;
        }

        .modal-content-detail {
            width: 85%;
            max-width: 850px;
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
        }

        .modal-header-detail {
            background: var(--primary-color);
            padding: 14px 18px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body-detail {
            max-height: 60vh;
            overflow-y: auto;
            padding: 18px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
        }

        .detail-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
        }

        .detail-key {
            width: 35%;
            font-weight: 600;
            background: #fff4e6;
            color: #663c00;
        }

        /* ===== RESPONSIVE STYLES ===== */
        @media (max-width: 880px) {
            .filter-bar {
                padding: 10px;
                gap: 8px;
            }
            
            .filter-search {
                flex-basis: 100%;
            }
            
            .filter-builder {
                gap: 8px;
            }
            
            .filter-row {
                padding: 10px;
                gap: 8px;
            }
            
            .filter-row .row-search-wrapper {
                flex-basis: 100%;
            }
            
            .filter-row select.row-cat {
                min-width: 140px;
            }
            
            .filter-row input[type="date"] {
                min-width: 140px;
            }
        }

        @media (max-width: 576px) {
            .container-main {
                padding: 0 10px;
            }
            
            .page-title {
                font-size: 24px;
            }
            
            .btn {
                padding: 4px 8px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container-main">
        <h1 class="page-title">Data Surat Tugas</h1>
        
        <!-- Search and Filter Section -->
        <div class="filter-bar">
            <div class="filter-search">
                <input type="text" id="tableSearch" placeholder="Search global...">
                <i class="fa fa-search"></i>
            </div>
            
            <div class="filter-actions">
                <select id="filterCategory" class="btn-small">
                    <option value="jenis" selected>Jenis Pengajuan</option>
                    <option value="dosen">Nama Dosen</option>
                    <option value="divisi">Divisi</option>
                    <option value="tanggal">Tanggal Pengajuan</option>
                </select>
                
                <button id="btnAddFilterRow" class="btn-small btn-add" title="Tambah baris filter">
                    <i class="fa fa-plus"></i>
                </button>
                
                <button id="btnResetAll" class="btn-small btn-reset" hidden title="Reset semua filter & pencarian">
                    <i class="fa fa-times"></i>&nbsp;Reset
                </button>
            </div>
        </div>
        
        <div id="filterBuilder" class="filter-builder"></div>
        
        <!-- Detail Modal -->
        <div id="modalDetail" class="modal-detail">
            <div class="modal-content-detail">
                <div class="modal-header-detail">
                    <span>Detail Data Surat</span>
                    <span class="close-modal" style="cursor:pointer;">&times;</span>
                </div>
                <div class="modal-body-detail">
                    <table class="detail-table" id="detailContent"></table>
                </div>
            </div>
        </div>
        
        <!-- Main Table -->
        <table id="tabelSurat" class="display nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kegiatan</th>
                    <th>Jenis Pengajuan</th>
                    <th>Nama Dosen</th>
                    <th>Divisi</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($surat_list as $s): ?>
                <?php
                    $detail = (array) $s;
                    foreach (['nip','nama_dosen','jabatan','divisi','eviden'] as $jf) {
                        if (isset($detail[$jf]) && is_string($detail[$jf])) {
                            $decoded = json_decode($detail[$jf], true);
                            if (json_last_error() === JSON_ERROR_NONE) $detail[$jf] = $decoded;
                        }
                    }
                    $data_detail_attr = htmlspecialchars(json_encode($detail, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES), ENT_QUOTES,'UTF-8');
                ?>
                <tr class="row-detail" data-detail='<?= $data_detail_attr; ?>'>
                    <td><?= $s->id; ?></td>
                    <td><?= htmlspecialchars($s->nama_kegiatan); ?></td>
                    <td><?= htmlspecialchars($s->jenis_pengajuan); ?></td>
                    <td>
                        <div class="dosen-container">
                            <?php
                                $nd = $s->nama_dosen;
                                if(is_string($nd)){ 
                                    $maybe=json_decode($nd,true); 
                                    if(json_last_error()===JSON_ERROR_NONE) $nd=$maybe; 
                                }
                                if(!empty($nd)){
                                    if(is_array($nd)){
                                        $nama=$nd[0]??'-';
                                        $short= strlen($nama)>30 ? substr($nama,0,30).'...' : $nama;
                                        echo '<span class="nama-dosen-badge" title="'.htmlspecialchars($nama).'">'.htmlspecialchars($short).'</span>';
                                        if(count($nd)>1) echo '<span class="nama-dosen-more" title="Klik row untuk lihat semua dosen">+'.(count($nd)-1).'</span>';
                                    } else {
                                        $nama=$nd;
                                        $short= strlen($nama)>30 ? substr($nama,0,30).'...' : $nama;
                                        echo '<span class="nama-dosen-badge" title="'.htmlspecialchars($nama).'">'.htmlspecialchars($short).'</span>';
                                    }
                                } else {
                                    echo '-';
                                }
                            ?>
                        </div>
                    </td>
                    <td>
                        <div class="divisi-container">
                            <?php
                                $dv=$s->divisi;
                                if(is_string($dv)){ 
                                    $maybe2=json_decode($dv,true); 
                                    if(json_last_error()===JSON_ERROR_NONE) $dv=$maybe2; 
                                }
                                if(!empty($dv)){
                                    if(is_array($dv)){ 
                                        foreach($dv as $div) {
                                            echo '<span class="divisi-badge">'.htmlspecialchars($div).'</span>';
                                        }
                                    } else {
                                        echo '<span class="divisi-badge">'.htmlspecialchars($dv).'</span>';
                                    }
                                } else {
                                    echo '-';
                                }
                            ?>
                        </div>
                    </td>
                    <td>
                        <?= isset($s->tanggal_pengajuan) && $s->tanggal_pengajuan ? htmlspecialchars($s->tanggal_pengajuan) : '-'; ?>
                    </td>
                    <td>
                        <a href="<?= site_url('surat/edit/'.$s->id); ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= site_url('surat/delete/'.$s->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</a>
                        <a href="<?= base_url('surat/cetak/' . $s->id) ?>" target="_blank" class="btn btn-info btn-sm">Cetak</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- JavaScript Dependencies -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Main JavaScript -->
    <script>
        $(document).ready(function () {
            const BASE_URL = '<?= rtrim(base_url(), "/"); ?>';
            
            // Initialize DataTable
            let table = $('#tabelSurat').DataTable({
                responsive: true,
                pageLength: 5,
                dom: 'rtp',
                columnDefs: [{orderable: false, targets: -1}]
            });

            // Prepare filter data from PHP
            const filterData = {
                jenis: <?= json_encode(array_values(array_unique(array_map(function($s){ 
                    return $s->jenis_pengajuan; 
                }, $surat_list)))); ?>,
                dosen: <?= json_encode(array_values(array_unique(array_reduce($surat_list, function($carry,$s){
                    if(isset($s->nama_dosen) && !empty($s->nama_dosen)){
                        $nd = $s->nama_dosen;
                        if(is_string($nd)){ 
                            $maybe = json_decode($nd,true); 
                            if(json_last_error() === JSON_ERROR_NONE) $nd = $maybe; 
                        }
                        if(is_array($nd)) {
                            foreach($nd as $d) $carry[] = trim($d); 
                        } else {
                            $carry[] = trim($nd);
                        }
                    }
                    return $carry;
                },[])))); ?>,
                divisi: <?= json_encode(array_values(array_unique(array_reduce($surat_list, function($carry,$s){
                    if(isset($s->divisi) && !empty($s->divisi)){
                        $dv = $s->divisi;
                        if(is_string($dv)){ 
                            $maybe2 = json_decode($dv,true); 
                            if(json_last_error() === JSON_ERROR_NONE) $dv = $maybe2; 
                        }
                        if(is_array($dv)) {
                            foreach($dv as $d) $carry[] = trim($d); 
                        } else {
                            $carry[] = trim($dv);
                        }
                    }
                    return $carry;
                },[])))); ?>
            };

            // Clean and sort filter data
            Object.keys(filterData).forEach(k => {
                filterData[k] = (filterData[k] || [])
                    .map(x => String(x || '').trim())
                    .filter(x => x !== '');
                filterData[k] = Array.from(new Set(filterData[k])).sort((a,b) => a.localeCompare(b));
            });

            // Filter management
            let rows = [];
            let uid = 0;
            
            function nextId() { 
                return 'r' + (++uid); 
            }

            function makeRowDOM(r) {
                const $wr = $(`<div class="filter-row" data-id="${r.id}"></div>`);
                const $searchWrapper = $(`<div class="row-search-wrapper"></div>`);
                const $search = $(`<input type="text" class="row-search" placeholder="Search..." />`);
                const $searchIcon = $(`<i class="fa fa-search"></i>`);
                const $dateStart = $(`<input type="date" class="row-date-start" style="display:none" />`);
                const $dateEnd = $(`<input type="date" class="row-date-end" style="display:none" />`);

                $searchWrapper.append($search).append($searchIcon);

                const $cat = $(`<select class="row-cat">
                    <option value="jenis">Jenis Pengajuan</option>
                    <option value="dosen">Nama Dosen</option>
                    <option value="divisi">Divisi</option>
                    <option value="tanggal">Tanggal Pengajuan</option>
                </select>`);

                const $btnAdd = $(`<button class="row-btn add" title="Tambah baris"><i class="fa fa-plus"></i></button>`);
                const $btnRemove = $(`<button class="row-btn remove" title="Hapus baris"><i class="fa fa-times"></i></button>`);

                // Set initial values
                if (r.category) $cat.val(r.category);
                if (r.text) $search.val(r.text);
                if (r.dateStart) $dateStart.val(r.dateStart);
                if (r.dateEnd) $dateEnd.val(r.dateEnd);

                function refreshInputs() {
                    const catVal = $cat.val();
                    if (catVal === 'tanggal') {
                        $searchWrapper.hide();
                        $dateStart.show();
                        $dateEnd.show();
                    } else {
                        $searchWrapper.show();
                        $dateStart.hide();
                        $dateEnd.hide();
                    }
                }
                refreshInputs();

                // Event handlers
                $search.on('input', function() {
                    const id = $wr.data('id');
                    const obj = rows.find(x => x.id === id);
                    if (!obj) return;
                    obj.text = $(this).val() || '';
                    applyFilters();
                });

                $dateStart.on('change', function() {
                    const id = $wr.data('id');
                    const obj = rows.find(x => x.id === id);
                    if (!obj) return;
                    obj.dateStart = $(this).val() || '';
                    applyFilters();
                });

                $dateEnd.on('change', function() {
                    const id = $wr.data('id');
                    const obj = rows.find(x => x.id === id);
                    if (!obj) return;
                    obj.dateEnd = $(this).val() || '';
                    applyFilters();
                });

                $cat.on('change', function() {
                    const id = $wr.data('id');
                    const obj = rows.find(x => x.id === id);
                    if (!obj) return;
                    obj.category = $(this).val();
                    obj.text = '';
                    obj.dateStart = '';
                    obj.dateEnd = '';
                    $search.val('');
                    $dateStart.val('');
                    $dateEnd.val('');
                    refreshInputs();
                    applyFilters();
                });

                $btnAdd.on('click', function() {
                    const id = $wr.data('id');
                    const idx = rows.findIndex(x => x.id === id);
                    const cur = rows[idx] || {};
                    const newRow = { 
                        id: nextId(), 
                        category: cur.category || 'jenis', 
                        text: '', 
                        dateStart: '', 
                        dateEnd: '' 
                    };
                    
                    if (idx >= 0 && idx < rows.length - 1) {
                        rows.splice(idx + 1, 0, newRow);
                    } else {
                        rows.push(newRow);
                    }
                    renderRows();
                    applyFilters();
                });

                $btnRemove.on('click', function() {
                    const id = $wr.data('id');
                    rows = rows.filter(x => x.id !== id);
                    renderRows();
                    applyFilters();
                });

                // Append elements
                $wr.append($searchWrapper)
                   .append($dateStart)
                   .append($dateEnd)
                   .append($cat)
                   .append($btnAdd)
                   .append($btnRemove);
                
                return $wr;
            }

            function renderRows() {
                const $b = $('#filterBuilder');
                $b.empty();
                rows.forEach(r => {
                    $b.append(makeRowDOM(r));
                });
                $('#btnResetAll').prop('hidden', rows.length === 0 && $('#tableSearch').val().trim() === '');
            }

            // Filter functionality
            $('#btnAddFilterRow').click(function() {
                const cat = $('#filterCategory').val() || 'jenis';
                rows.push({ 
                    id: nextId(), 
                    category: cat, 
                    text: '', 
                    dateStart: '', 
                    dateEnd: '' 
                });
                renderRows();
                applyFilters();
            });

            // Custom DataTable filter
            $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(fn => fn.name !== 'customRowsFilter');

            const customRowsFilter = function(settings, data) {
                const q = $('#tableSearch').val().trim().toLowerCase();
                if (q) {
                    const keywords = q.split(/\s+/).filter(x => x);
                    const rowText = data.join(' ').toLowerCase();
                    const okText = keywords.every(k => rowText.indexOf(k) >= 0);
                    if (!okText) return false;
                }

                for (const r of rows) {
                    if (!r || !r.category) continue;

                    if (r.category === 'tanggal') {
                        const cell = (data[5] || '').trim();
                        const start = r.dateStart || '';
                        const end = r.dateEnd || '';
                        if (!start && !end) continue;
                        if (!cell || cell === '-') return false;
                        if (start && cell < start) return false;
                        if (end && cell > end) return false;
                        continue;
                    }

                    const colIndex = (r.category === 'jenis') ? 2 : (r.category === 'dosen' ? 3 : 4);
                    const cellRaw = (data[colIndex] || '').toLowerCase();

                    if (!r.text || String(r.text).trim() === '') continue;

                    const needle = String(r.text).toLowerCase().trim();
                    if (cellRaw.indexOf(needle) === -1) return false;
                }

                return true;
            };
            
            Object.defineProperty(customRowsFilter, 'name', { value: 'customRowsFilter' });
            $.fn.dataTable.ext.search.push(customRowsFilter);

            function applyFilters() {
                table.draw();
                const anyFilterActive = rows.length > 0 || $('#tableSearch').val().trim() !== '';
                $('#btnResetAll').prop('hidden', !anyFilterActive);
            }

            let debounce = null;
            $('#tableSearch').on('input', function() {
                if (debounce) clearTimeout(debounce);
                debounce = setTimeout(() => applyFilters(), 180);
            });

            $('#btnResetAll').click(function() {
                rows = [];
                $('#tableSearch').val('');
                renderRows();
                applyFilters();
            });

            // Initialize with one row
            rows.push({ 
                id: nextId(), 
                category: 'jenis', 
                text: '', 
                dateStart: '', 
                dateEnd: '' 
            });
            renderRows();

            // Modal functionality
            $('#tabelSurat tbody').on('click', 'tr.row-detail', function(e) {
                if ($(e.target).closest('a').length) return;
                
                let raw = $(this).attr('data-detail') || '{}';
                let data = {};
                try { 
                    data = JSON.parse(raw);
                } catch(err) { 
                    console.error(err);
                }
                
                let html = '';
                Object.entries(data).forEach(([k, v]) => {
                    let display = v;
                    if (display === null || display === undefined || (typeof display === 'string' && display.trim() === '')) {
                        display = '-';
                    }
                    
                    if (k === 'eviden') {
                        if (typeof display === 'string') { 
                            try {
                                display = JSON.parse(display);
                            } catch(e) {} 
                        }
                        if (Array.isArray(display) && display.length > 0) {
                            let list = '<ul style="margin:0;padding-left:18px;">';
                            display.forEach(item => {
                                let url = '', name = '';
                                if (typeof item === 'string') { 
                                    url = item; 
                                    name = item.split('/').pop().split('?')[0]; 
                                } else if (typeof item === 'object' && item !== null) {
                                    url = item.cdnUrl || item.path || item.url || '';
                                    if (item.nama_asli) name = item.nama_asli;
                                    else if (item.name) name = item.name;
                                    else name = url.split('/').pop().split('?')[0];
                                    if (url && !url.match(/^https?:\/\//i)) {
                                        url = BASE_URL + (url.startsWith('/') ? '' : '/') + url;
                                    }
                                }
                                const escName = $('<div/>').text(name).html();
                                const escUrl = $('<div/>').text(url).html();
                                list += `<li style="margin-bottom:6px;">
                                    <a href="#" class="force-download" data-url="${escUrl}" data-name="${escName}" 
                                       style="color:#FB8C00;font-weight:600;text-decoration:none;">
                                        📄 ${escName}
                                    </a>
                                </li>`;
                            });
                            list += '</ul>';
                            display = list;
                        } else {
                            display = '-';
                        }
                    } else if (Array.isArray(display)) {
                        display = display.map(x => $('<div/>').text(String(x)).html()).join('<br>');
                    } else {
                        if (typeof display === 'string') {
                            display = $('<div/>').text(display).html();
                        }
                    }
                    
                    html += `<tr>
                        <td class="detail-key">${k.replace(/_/g, ' ')}</td>
                        <td>${display}</td>
                    </tr>`;
                });
                
                $('#detailContent').html(html);
                $('#modalDetail').addClass('show');
            });

            // File download functionality
            $(document).on("click", ".force-download", function(e) {
                e.preventDefault();
                const url = $(this).data("url");
                const name = $(this).data("name");
                const link = document.createElement("a");
                link.href = url + "?download=1";
                link.download = name || "file";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });

            // Modal close functionality
            $('.close-modal').click(() => $('#modalDetail').removeClass('show'));
            $(window).click(e => { 
                if (e.target.id === 'modalDetail') {
                    $('#modalDetail').removeClass('show');
                }
            });
        });
    </script>
</body>
</html>