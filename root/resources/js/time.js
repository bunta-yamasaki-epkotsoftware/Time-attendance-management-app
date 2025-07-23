function updateDateTime() {
    const now = new Date();

    // 日付のフォーマット（2022/3/7(月)）
    const year = now.getFullYear();
    const month = now.getMonth() + 1;
    const date = now.getDate();
    const dayNames = ['日', '月', '火', '水', '木', '金', '土'];
    const dayName = dayNames[now.getDay()];

    const dateString = `${year}/${month}/${date}(${dayName})`;

    // 時刻のフォーマット（15:51:05）
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');

    const timeString = `${hours}:${minutes}:${seconds}`;

    // DOM要素に表示
    document.getElementById('current-date').textContent = dateString;
    document.getElementById('current-time').textContent = timeString;

    // グローバル変数として保存（フォーム送信時に使用）
    window.currentFormattedDate = dateString;
    window.currentFormattedTime = timeString;

    // データベース用のフォーマット
    window.currentDBDate = `${year}-${month.toString().padStart(2, '0')}-${date.toString().padStart(2, '0')}`;
    window.currentDBTime = timeString;
}

// DOM読み込み完了後に実行
document.addEventListener('DOMContentLoaded', function() {
    // 初回実行
    updateDateTime();

    // 1秒ごとに更新
    setInterval(updateDateTime, 1000);

    // フォーム送信時にメモをhiddenフィールドに設定
    document.getElementById('clockin-form').addEventListener('submit', function(e) {
        document.getElementById('clockin-notes').value = document.getElementById('attendance-memo').value;
    });
    document.getElementById('clockout-form').addEventListener('submit', function(e) {
        document.getElementById('clockout-notes').value = document.getElementById('attendance-memo').value;
    });
});