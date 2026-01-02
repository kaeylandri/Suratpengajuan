<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'WhatsApp Server Control Panel' ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Socket.IO Client -->
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border: none;
            margin-bottom: 20px;
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
            border: none;
        }
        
        .status-badge {
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 25px;
            display: inline-block;
            margin: 5px;
            font-weight: 600;
        }
        
        .qr-container {
            text-align: center;
            padding: 40px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 15px;
            margin: 20px 0;
        }
        
        .qr-container img {
            max-width: 300px;
            border: 3px solid #667eea;
            padding: 15px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .log-container {
            background: #1e1e1e;
            color: #00ff00;
            padding: 20px;
            border-radius: 10px;
            max-height: 400px;
            overflow-y: auto;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            line-height: 1.6;
        }
        
        .log-container::-webkit-scrollbar {
            width: 10px;
        }
        
        .log-container::-webkit-scrollbar-track {
            background: #2d2d2d;
            border-radius: 10px;
        }
        
        .log-container::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 10px;
        }
        
        .btn-custom {
            border-radius: 25px;
            padding: 10px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .spinner-border-custom {
            width: 20px;
            height: 20px;
            border-width: 2px;
        }
        
        .instruction-box {
            background: #fff3cd;
            border-left: 5px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
        }
        
        .stats-card {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            margin-bottom: 15px;
        }
        
        .stats-card h3 {
            margin: 0;
            font-size: 24px;
        }
        
        .stats-card p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Header -->
        <div class="text-center mb-4 fade-in">
            <h1 class="text-white mb-3">
                <i class="fab fa-whatsapp"></i> WhatsApp Server Control Panel
            </h1>
            <p class="text-white-50">Kelola WhatsApp Broadcast Server dari Browser</p>
        </div>
        
        <!-- Status Cards -->
        <div class="row mb-4 fade-in">
            <div class="col-md-6">
                <div class="stats-card">
                    <h3><i class="fas fa-server"></i> Server Status</h3>
                    <p id="server-status-text">Checking...</p>
                    <span id="server-status-badge" class="status-badge bg-secondary">
                        <i class="fas fa-circle-notch fa-spin"></i> Checking...
                    </span>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="stats-card">
                    <h3><i class="fab fa-whatsapp"></i> WhatsApp Status</h3>
                    <p id="wa-status-text">Not Connected</p>
                    <span id="wa-status-badge" class="status-badge bg-secondary">
                        <i class="fas fa-times-circle"></i> Disconnected
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Control Panel -->
<div class="card fade-in">
    <div class="card-header">
        <h4 class="mb-0"><i class="fas fa-sliders-h"></i> Control Panel</h4>
    </div>
    <div class="card-body">
        <!-- Server Control Buttons -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <button class="btn btn-success btn-custom w-100" id="btn-start-server" onclick="startServer()" <?= $is_running ? 'disabled' : '' ?>>
                    <i class="fas fa-play-circle"></i> <span id="start-text">Start Server</span>
                </button>
            </div>
            
            <div class="col-md-6 mb-3">
                <button class="btn btn-danger btn-custom w-100" id="btn-stop-server" onclick="stopServer()" <?= !$is_running ? 'disabled' : '' ?>>
                    <i class="fas fa-stop-circle"></i> <span id="stop-text">Stop Server</span>
                </button>
            </div>
        </div>
        
        <hr>
        
        <!-- Other Control Buttons -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <button class="btn btn-info btn-custom w-100" onclick="checkStatus()">
                    <i class="fas fa-sync-alt"></i> Refresh Status
                </button>
            </div>
            
            <div class="col-md-4 mb-3">
                <button class="btn btn-warning btn-custom w-100" onclick="restartServer()">
                    <i class="fas fa-redo"></i> Restart Server
                </button>
            </div>
            
            <div class="col-md-4 mb-3">
                <button class="btn btn-primary btn-custom w-100" onclick="openServerInterface()">
                    <i class="fas fa-external-link-alt"></i> Open Server UI
                </button>
            </div>
        </div>
        
        <div class="instruction-box">
            <strong><i class="fas fa-info-circle"></i> Cara Penggunaan:</strong>
            <ol class="mb-0 mt-2">
                <li><strong>Klik "Start Server"</strong> untuk menjalankan WhatsApp server</li>
                <li>Tunggu beberapa detik hingga server siap</li>
                <li>Jika belum scan QR, QR Code akan muncul otomatis di bawah</li>
                <li>Scan QR Code dengan WhatsApp di HP Anda</li>
                <li>Setelah terhubung, status akan berubah menjadi "Connected"</li>
                <li>Pesan akan otomatis terkirim saat ada pengajuan baru</li>
                <li>Klik "Stop Server" untuk menghentikan server</li>
            </ol>
        </div>
    </div>
</div>
        
        <!-- QR Code Section -->
        <div id="qr-section" class="card fade-in" style="display: none;">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-qrcode"></i> Scan QR Code</h4>
            </div>
            <div class="card-body">
                <div class="qr-container">
                    <img id="qr-code" src="" alt="QR Code" class="pulse">
                    <div class="mt-4">
                        <h5 class="text-muted"><i class="fas fa-mobile-alt"></i> Langkah-langkah:</h5>
                        <ol class="text-start text-muted" style="max-width: 400px; margin: 0 auto;">
                            <li>Buka WhatsApp di HP Anda</li>
                            <li>Tap menu <strong>⋮</strong> (titik tiga)</li>
                            <li>Pilih <strong>Linked Devices</strong></li>
                            <li>Tap <strong>Link a Device</strong></li>
                            <li>Scan QR Code di atas</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Test Send Message -->
        <div class="card fade-in">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-paper-plane"></i> Test Kirim Pesan</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor Tujuan:</label>
                        <input type="text" class="form-control" id="test-nomor" placeholder="6282119509135" value="6282119509135">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button class="btn btn-primary btn-custom w-100" onclick="testSendMessage()">
                            <i class="fas fa-paper-plane"></i> Kirim Test Pesan
                        </button>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Pesan:</label>
                    <textarea class="form-control" id="test-pesan" rows="3" placeholder="Tulis pesan test...">🧪 Test pesan dari WhatsApp Server Dashboard</textarea>
                </div>
                
                <div id="send-result" class="alert" style="display: none;"></div>
            </div>
        </div>
        
        <!-- Logs -->
        <div class="card fade-in">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-terminal"></i> Server Logs</h4>
            </div>
            <div class="card-body">
                <div id="logs" class="log-container">
                    <span style="color: #00ff00;">Waiting for server connection...</span>
                </div>
                <button class="btn btn-sm btn-secondary mt-2" onclick="clearLogs()">
                    <i class="fas fa-trash"></i> Clear Logs
                </button>
            </div>
        </div>
        
        <!-- Back Button -->
        <div class="text-center mt-4 mb-4">
            <a href="<?= base_url('list-surat-tugas') ?>" class="btn btn-light btn-custom">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Socket.IO connection
        const socket = io('http://localhost:3000');
        
        // Connection status
        socket.on('connect', () => {
            addLog('✅ Connected to WhatsApp server', 'success');
            updateServerStatus(true);
            checkStatus();
        });
        
        socket.on('disconnect', () => {
            addLog('❌ Disconnected from server', 'error');
            updateServerStatus(false);
        });
        
        // QR Code received
        socket.on('qr', (qrData) => {
            addLog('📱 QR Code received - Please scan with WhatsApp', 'info');
            document.getElementById('qr-section').style.display = 'block';
            document.getElementById('qr-code').src = qrData;
            
            // Update status
            updateWAStatus('qr_ready', 'Scan QR Code');
        });
        
        // WhatsApp ready
        socket.on('ready', () => {
            addLog('✅ WhatsApp client ready!', 'success');
            document.getElementById('qr-section').style.display = 'none';
            updateWAStatus('connected', 'Connected');
        });
        
        // Status update
        socket.on('status', (data) => {
            addLog('Status: ' + data.message, 'info');
            
            if (data.status === 'connected') {
                updateWAStatus('connected', 'Connected');
            } else if (data.status === 'disconnected') {
                updateWAStatus('disconnected', 'Disconnected');
            } else if (data.status === 'qr_ready') {
                updateWAStatus('qr_ready', 'Scan QR Code');
            }
        });
        
        // Loading progress
        socket.on('loading', (data) => {
            addLog('📥 Loading: ' + data.percent + '%', 'info');
        });
        
        // Update server status display
        function updateServerStatus(isOnline) {
            const badge = document.getElementById('server-status-badge');
            const text = document.getElementById('server-status-text');
            
            if (isOnline) {
                badge.className = 'status-badge bg-success';
                badge.innerHTML = '<i class="fas fa-check-circle"></i> Online';
                text.textContent = 'Server is running';
            } else {
                badge.className = 'status-badge bg-danger';
                badge.innerHTML = '<i class="fas fa-times-circle"></i> Offline';
                text.textContent = 'Server not responding';
            }
        }
        
        // Update WhatsApp status display
        function updateWAStatus(status, message) {
            const badge = document.getElementById('wa-status-badge');
            const text = document.getElementById('wa-status-text');
            
            text.textContent = message;
            
            switch(status) {
                case 'connected':
                    badge.className = 'status-badge bg-success';
                    badge.innerHTML = '<i class="fas fa-check-circle"></i> Connected';
                    break;
                case 'qr_ready':
                    badge.className = 'status-badge bg-warning';
                    badge.innerHTML = '<i class="fas fa-qrcode"></i> Scan QR Code';
                    break;
                case 'disconnected':
                    badge.className = 'status-badge bg-danger';
                    badge.innerHTML = '<i class="fas fa-times-circle"></i> Disconnected';
                    break;
                default:
                    badge.className = 'status-badge bg-secondary';
                    badge.innerHTML = '<i class="fas fa-question-circle"></i> Unknown';
            }
        }
        
        // Add log entry
        function addLog(message, type = 'info') {
            const logs = document.getElementById('logs');
            const timestamp = new Date().toLocaleTimeString();
            
            let color = '#00ff00';
            if (type === 'error') color = '#ff0000';
            if (type === 'warning') color = '#ffff00';
            if (type === 'success') color = '#00ff00';
            
            logs.innerHTML += `<span style="color: ${color};">[${timestamp}] ${message}</span>\n`;
            logs.scrollTop = logs.scrollHeight;
        }
        
        // Clear logs
        function clearLogs() {
            document.getElementById('logs').innerHTML = '<span style="color: #00ff00;">Logs cleared</span>\n';
        }
        
        // Check server status (via PHP)
        function checkStatus() {
            addLog('🔍 Checking server status...', 'info');
            
            $.ajax({
                url: '<?= base_url("whatsapp/get_status") ?>',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.online) {
                        updateServerStatus(true);
                        
                        if (response.ready) {
                            updateWAStatus('connected', 'WhatsApp Connected');
                            addLog('✅ WhatsApp is ready', 'success');
                        } else {
                            updateWAStatus(response.whatsapp_status, 'Checking...');
                            addLog('⚠️ WhatsApp not ready yet', 'warning');
                        }
                    } else {
                        updateServerStatus(false);
                        updateWAStatus('disconnected', 'Server Offline');
                        addLog('❌ Server is offline', 'error');
                    }
                },
                error: function() {
                    updateServerStatus(false);
                    addLog('❌ Failed to check status', 'error');
                }
            });
        }
        
        // Restart server
        function restartServer() {
            if (!confirm('Restart WhatsApp server? Koneksi akan terputus sementara.')) {
                return;
            }
            
            addLog('🔄 Restarting server...', 'warning');
            
            $.ajax({
                url: '<?= base_url("whatsapp/restart") ?>',
                method: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        addLog('✅ Server restarting...', 'success');
                        
                        // Check status after 5 seconds
                        setTimeout(() => {
                            checkStatus();
                        }, 5000);
                    } else {
                        addLog('❌ Failed to restart: ' + response.error, 'error');
                    }
                },
                error: function() {
                    addLog('❌ Failed to restart server', 'error');
                }
            });
        }
        
        // Open server UI in new tab
        function openServerInterface() {
            window.open('http://localhost:3000', '_blank');
        }
        
        // Test send message
        function testSendMessage() {
            const nomor = document.getElementById('test-nomor').value.trim();
            const pesan = document.getElementById('test-pesan').value.trim();
            const resultDiv = document.getElementById('send-result');
            
            if (!nomor || !pesan) {
                resultDiv.className = 'alert alert-warning';
                resultDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Nomor dan pesan harus diisi!';
                resultDiv.style.display = 'block';
                return;
            }
            
            addLog('📤 Sending test message to ' + nomor + '...', 'info');
            resultDiv.style.display = 'none';
            
            $.ajax({
                url: '<?= base_url("whatsapp/test_send") ?>',
                method: 'POST',
                data: { nomor: nomor, pesan: pesan },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        resultDiv.className = 'alert alert-success';
                        resultDiv.innerHTML = '<i class="fas fa-check-circle"></i> Pesan berhasil dikirim ke ' + nomor;
                        addLog('✅ Test message sent successfully', 'success');
                    } else {
                        resultDiv.className = 'alert alert-danger';
                        resultDiv.innerHTML = '<i class="fas fa-times-circle"></i> Gagal kirim: ' + response.error;
                        addLog('❌ Failed to send: ' + response.error, 'error');
                    }
                    resultDiv.style.display = 'block';
                },
                error: function() {
                    resultDiv.className = 'alert alert-danger';
                    resultDiv.innerHTML = '<i class="fas fa-times-circle"></i> Terjadi kesalahan saat mengirim pesan';
                    resultDiv.style.display = 'block';
                    addLog('❌ Failed to send test message', 'error');
                }
            });
        }
        
        // Auto-check status on load
        $(document).ready(function() {
            checkStatus();
            
            // Auto-refresh every 30 seconds
            setInterval(checkStatus, 30000);
        });
        // Start server
function startServer() {
    const btn = document.getElementById('btn-start-server');
    const btnText = document.getElementById('start-text');
    const originalText = btnText.textContent;
    
    btn.disabled = true;
    btnText.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Starting...';
    
    addLog('🚀 Starting WhatsApp server...', 'info');
    
    $.ajax({
        url: '<?= base_url("whatsapp/start_server") ?>',
        method: 'POST',
        dataType: 'json',
        timeout: 10000,
        success: function(response) {
            if (response.success) {
                addLog('✅ ' + response.message, 'success');
                
                // Update button states
                btn.disabled = true;
                document.getElementById('btn-stop-server').disabled = false;
                
                // Check status after 3 seconds
                setTimeout(() => {
                    checkStatus();
                }, 3000);
                
                // Show success alert
                showAlert('success', response.message);
            } else {
                addLog('❌ ' + response.message, 'error');
                btn.disabled = false;
                showAlert('danger', response.message);
            }
            
            btnText.textContent = originalText;
        },
        error: function(xhr, status, error) {
            addLog('❌ Error: ' + error, 'error');
            btn.disabled = false;
            btnText.textContent = originalText;
            showAlert('danger', 'Gagal menjalankan server: ' + error);
        }
    });
}

// Stop server
function stopServer() {
    if (!confirm('Stop WhatsApp server? Koneksi WhatsApp akan terputus.')) {
        return;
    }
    
    const btn = document.getElementById('btn-stop-server');
    const btnText = document.getElementById('stop-text');
    const originalText = btnText.textContent;
    
    btn.disabled = true;
    btnText.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Stopping...';
    
    addLog('🛑 Stopping WhatsApp server...', 'warning');
    
    $.ajax({
        url: '<?= base_url("whatsapp/stop_server") ?>',
        method: 'POST',
        dataType: 'json',
        timeout: 10000,
        success: function(response) {
            if (response.success) {
                addLog('✅ ' + response.message, 'success');
                
                // Update button states
                btn.disabled = true;
                document.getElementById('btn-start-server').disabled = false;
                
                // Update status
                updateServerStatus(false);
                updateWAStatus('disconnected', 'Server Stopped');
                
                // Hide QR section
                document.getElementById('qr-section').style.display = 'none';
                
                showAlert('success', response.message);
            } else {
                addLog('❌ ' + response.message, 'error');
                btn.disabled = false;
                showAlert('danger', response.message);
            }
            
            btnText.textContent = originalText;
        },
        error: function(xhr, status, error) {
            addLog('❌ Error: ' + error, 'error');
            btn.disabled = false;
            btnText.textContent = originalText;
            showAlert('danger', 'Gagal menghentikan server: ' + error);
        }
    });
}

// Show alert notification
function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            <strong>${type === 'success' ? '✅ Berhasil!' : '❌ Error!'}</strong><br>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('body').append(alertHtml);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        $('.alert').fadeOut(() => {
            $('.alert').remove();
        });
    }, 5000);
}

// Update check status function
function checkStatus() {
    addLog('🔍 Checking server status...', 'info');
    
    $.ajax({
        url: '<?= base_url("whatsapp/get_status") ?>',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.online && response.is_running) {
                updateServerStatus(true);
                
                // Update button states
                document.getElementById('btn-start-server').disabled = true;
                document.getElementById('btn-stop-server').disabled = false;
                
                if (response.ready) {
                    updateWAStatus('connected', 'WhatsApp Connected');
                    addLog('✅ WhatsApp is ready', 'success');
                } else {
                    updateWAStatus(response.whatsapp_status, 'Checking...');
                    addLog('⚠️ WhatsApp not ready yet', 'warning');
                }
            } else {
                updateServerStatus(false);
                updateWAStatus('disconnected', 'Server Offline');
                addLog('❌ Server is offline', 'error');
                
                // Update button states
                document.getElementById('btn-start-server').disabled = false;
                document.getElementById('btn-stop-server').disabled = true;
            }
        },
        error: function() {
            updateServerStatus(false);
            addLog('❌ Failed to check status', 'error');
            
            // Update button states
            document.getElementById('btn-start-server').disabled = false;
            document.getElementById('btn-stop-server').disabled = true;
        }
    });
}
    </script>
</body>
</html>