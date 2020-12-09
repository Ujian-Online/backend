function adminDashboard(url) {
	axios
		.get(url)
		.then((res) => res.data)
		.then((res) => {
			document.getElementById('dashboard-user').innerHTML = res.users;
			document.getElementById('dashboard-share').innerHTML = res.share.total
				? res.share.total
				: 0;
			document.getElementById('dashboard-view').innerHTML = res.share.total_views
				? res.share.total_views
				: 0;
			document.getElementById('dashboard-download').innerHTML = res.share.total_download
				? res.share.total_download
				: 0;
		})
		.catch((err) => alert('Error Mengambil Data'));
}

$('body').on('click', '.btn-delete', async function (event) {
	event.preventDefault();

	var me = $(this),
		url = me.attr('href');

	if (confirm('Lanjutkan Menghapus Data?')) {
		try {
			// request delete
			await axios.delete(url, {
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
					'Content-Type': 'application/x-www-form-urlencoded',
				},
			});

			// reload
			$('.buttons-reload').click();
		} catch (e) {
			alert('Gagal Menghapus Data.!');
		}
	}
});
