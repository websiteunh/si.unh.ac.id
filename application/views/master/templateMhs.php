<?php
$d = date('dms'); 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=template-mhs-".$d.".xls");
header("Pragma: no-cache");
header("Expires: 0");

?>      
<b>
	Catatan : <br>
	1. Sesuaikan field Golongan, Kategori dan Satuan dengan tabel yg tersedia, kemudian Hapus sebelum import.
	2. Setelah selesai, hapus 3 tabel acuan dan Save As dengan format "*.xlsx".
</b>
<table class="table table-hover table-striped" border="1">
	<thead>
	<tr>                
		<th>Nama Lengkap</th>                            
		<th>NIM</th>		              
		<th>No HP</th>		              
	</tr>
	</thead>
	<tbody>
		<tr>
			<td></td>
			<td></td>
			<td></td>                   
		</tr>                                           
	</tbody>
</table>
