@section('plugins.Select2', true)
<x-app-layout title="Tambah Siswa">
	<x-form method="POST" action="{{ route('admin.siswa.store') }}">
		<x-adminlte-card theme="lime" theme-mode="outline" title="Isi Data Siswa">
			<div class="row">
				<x-adminlte-input name="nama_siswa" label="Nama Siswa" placeholder="Alfalah" fgroup-class="col-md-4" required />
				<x-adminlte-input name="nomor_kip" label="No KIP" placeholder="1234567890123456" fgroup-class="col-md-4" type="number" required />
				<x-adminlte-input name="nis" label="NIS" placeholder="7077" fgroup-class="col-md-4" type="number" required />
			</div>
			<div class="row">
				<x-adminlte-input name="nisn" label="NISN" placeholder="1277471818" fgroup-class="col-md-3" type="number" required />
				<x-adminlte-input name="nik" label="NIK" min=1000000000000000 max=9999999999999999 placeholder="1234567890123456" fgroup-class="col-md-3" type="number" required />
				<x-adminlte-select2 name="id_kelas" fgroup-class="col-md-3" label="Kelas">
					@foreach($kelas as $kls)
					@if($jumlah_siswa[0]->jml_siswa < $kls->kapasitas_kelas)
						<option value="{{ $kls->id }}">{{$kls->nama_kelas.' '.$kls->tingkat.' - '.$jumlah_siswa[0]->jml_siswa.'/'.$kls->kapasitas_kelas}}</option>
						@endif
						@endforeach
				</x-adminlte-select2>
				<x-adminlte-select2 name="status_siswa" fgroup-class="col-md-3" label="Status Siswa">
					<x-slot name="prependSlot">
						<div class="input-group-text bg-gradient-info">
							<i class="fas fa-user"></i>
						</div>
					</x-slot>
					<option value="Aktif">Aktif</option>
					<option value="Tidak Aktif">Tidak Aktif</option>
				</x-adminlte-select2>
			</div>
			<div class="row">
				<x-adminlte-select2 name="current_state" fgroup-class="col-md-3" label="Tahun Ajaran">
					@foreach($tahunpelajaran as $tp)
					<option value="{{ $tp }}">{{$tp}}</option>
					@endforeach
				</x-adminlte-select2>
				<x-adminlte-input name="tempat_lahir" label="Tempat Lahir" placeholder="Semarang" fgroup-class="col-md-3" required />
				<x-adminlte-input-date name="tanggal_lahir" :config="$config_date" label="Tanggal Lahir" placeholder="Choose a time..." fgroup-class="col-md-3" required>
					<x-slot name="prependSlot">
						<div class="input-group-text bg-gradient-info">
							<i class="fas fa-clock"></i>
						</div>
					</x-slot>
				</x-adminlte-input-date>
				<x-adminlte-select2 name="jenis_kelamin" fgroup-class="col-md-3" label="Jenis Kelamin">
					<x-slot name="prependSlot">
						<div class="input-group-text bg-gradient-info">
							<i class="fas fa-align-justify"></i>
						</div>
					</x-slot>
					<option value="Laki Laki">Laki Laki</option>
					<option value="Perempuan">Perempuan</option>
				</x-adminlte-select2>
			</div>
			<div class="row">
				<x-adminlte-input name="nomor_kk" label="No KK" min=1000000000000000 max=9999999999999999 placeholder="1234567890123456" fgroup-class="col-md-4" type="number" required />
				<x-adminlte-input-file name="file_kk" igroup-size="md" placeholder="Pilih file..." label="Upload KK" fgroup-class="col-md-4">
					<x-slot name="prependSlot_ayah">
						<div class="input-group-text bg-lightblue">
							<i class="fas fa-address-card"></i>
						</div>
					</x-slot>
				</x-adminlte-input-file>
				<x-adminlte-textarea name="alamat" fgroup-class="col-md-4" label="Alamat" placeholder="Masukkan alamat" />
			</div>
		</x-adminlte-card>
		<div class="row">
			<div class="col-md-6">
				<x-adminlte-card theme="lightblue" theme-mode="outline" title="Isi Data Ayah">
					<div class="row">
						<x-adminlte-input-file name="file_kk_ayah" igroup-size="md" placeholder="Pilih file..." label="File KK Ayah" fgroup-class="col-md-6">
							<x-slot name="prependSlot_ayah">
								<div class="input-group-text bg-lightblue">
									<i class="fas fa-address-card"></i>
								</div>
							</x-slot>
						</x-adminlte-input-file>
						<x-adminlte-input name="nama_ayah" label="Nama" placeholder="Alfa" fgroup-class="col-md-6" required />
					</div>
					<div class="row">
						<x-adminlte-input name="nik_ayah" type="number" label="NIK" min=1000000000000000 max=9999999999999999 placeholder="3324xxxxxxxx" fgroup-class="col-md-6" required />
						<x-adminlte-input-date name="tanggal_lahir_ayah" :config="$config_date" label="Tanggal Lahir" placeholder="Choose a time..." fgroup-class="col-md-6" required>
							<x-slot name="prependSlot_ayah">
								<div class="input-group-text bg-gradient-info">
									<i class="fas fa-clock"></i>
								</div>
							</x-slot>
						</x-adminlte-input-date>
					</div>
					<div class="row">
						<x-adminlte-input name="tempat_lahir_ayah" label="Tempat Lahir" placeholder="Semarang" fgroup-class="col-md-6" required />
						<x-adminlte-select2 name="status_keluarga_ayah" fgroup-class="col-md-6" label="Status Ayah">
							<x-slot name="prependSlot_ayah">
								<div class="input-group-text bg-gradient-info">
									<i class="fas fa-school"></i>
								</div>
							</x-slot>
							<option value="Kandung">Kandung</option>
							<option value="Tiri">Tiri</option>
						</x-adminlte-select2>

					</div>
					<div class="row">
						<x-adminlte-select2 name="status_hidup_ayah" fgroup-class="col-md-6" label="Status">
							<x-slot name="prependSlot_ayah">
								<div class="input-group-text bg-gradient-info">
									<i class="fas fa-school"></i>
								</div>
							</x-slot>
							<option value="Masih Hidup">Masih Hidup</option>
							<option value="Meninggal Dunia">Meninggal Dunia</option>
							<option value="Tidak Diketahui">Tidak Diketahui</option>
						</x-adminlte-select2>
						<x-adminlte-input name="pekerjaan_ayah" label="Pekerjaan" placeholder="PNS" fgroup-class="col-md-6" required />
					</div>
					<div class="row">
						<x-adminlte-select2 name="pendidikan_ayah" fgroup-class="col-md-6" label="Pendidikan Terakhir">
							<x-slot name="prependSlot_ayah">
								<div class="input-group-text bg-gradient-info">
									<i class="fas fa-school"></i>
								</div>
							</x-slot>
							<option value="SD/Sederajat">SD/Sederajat</option>
							<option value="SMP/Sederajat">SMP/Sederajat</option>
							<option value="SMA/Sederajat">SMA/Sederajat</option>
							<option value="D1">D1</option>
							<option value="D2">D2</option>
							<option value="D3">D3</option>
							<option value="D4/S1">D4/S1</option>
							<option value="S2">S2</option>
							<option value="S3">S3</option>
							<option value="Tidak Bersekolah">Tidak Bersekolah</option>
						</x-adminlte-select2>
						<x-adminlte-input name="penghasilan_ayah" label="Penghasilan Perbulan" placeholder="124155151" type="number" fgroup-class="col-md-6" required />
					</div>
					<div class="row">
						<x-adminlte-input name="no_hp_ayah" label="Nomor Handphone/Telp" placeholder="08123456789" type="text" fgroup-class="col-md-6" required />
						<x-adminlte-textarea name="alamat_ayah" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat" />
					</div>
				</x-adminlte-card>
			</div>
			<div class="col-md-6">
				<x-adminlte-card theme="lightblue" theme-mode="outline" title="Isi Data Ibu">
					<div class="row">
						<x-adminlte-input-file name="file_kk_ibu" igroup-size="md" placeholder="Pilih file..." label="File KK Ibu" fgroup-class="col-md-6">
							<x-slot name="prependSlot_ayah">
								<div class="input-group-text bg-lightblue">
									<i class="fas fa-address-card"></i>
								</div>
							</x-slot>
						</x-adminlte-input-file>
						<x-adminlte-input name="nama_ibu" label="Nama" placeholder="Alfa" fgroup-class="col-md-6" required />
					</div>
					<div class="row">
						<x-adminlte-input name="nik_ibu" label="NIK" type="number" min=1000000000000000 max=9999999999999999 placeholder="3324xxxxxxxx" fgroup-class="col-md-6" required />
						<x-adminlte-input-date name="tanggal_lahir_ibu" :config="$config_date" label="Tanggal Lahir" placeholder="Choose a time..." fgroup-class="col-md-6" required>
							<x-slot name="prependSlot_ibu">
								<div class="input-group-text bg-gradient-info">
									<i class="fas fa-clock"></i>
								</div>
							</x-slot>
						</x-adminlte-input-date>
					</div>
					<div class="row">
						<x-adminlte-input name="tempat_lahir_ibu" label="Tempat Lahir" placeholder="Semarang" fgroup-class="col-md-6" required />
						<x-adminlte-select2 name="status_keluarga_ibu" fgroup-class="col-md-6" label="Status Ibu">
							<x-slot name="prependSlot_ayah">
								<div class="input-group-text bg-gradient-info">
									<i class="fas fa-school"></i>
								</div>
							</x-slot>
							<option value="Kandung">Kandung</option>
							<option value="Tiri">Tiri</option>
						</x-adminlte-select2>
						<x-adminlte-select2 name="status_hidup_ibu" fgroup-class="col-md-6" label="Status">
							<x-slot name="prependSlot_ayah">
								<div class="input-group-text bg-gradient-info">
									<i class="fas fa-school"></i>
								</div>
							</x-slot>
							<option value="Masih Hidup">Masih Hidup</option>
							<option value="Meninggal Dunia">Meninggal Dunia</option>
							<option value="Tidak Diketahui">Tidak Diketahui</option>
						</x-adminlte-select2>
						<x-adminlte-input name="pekerjaan_ibu" label="Pekerjaan" placeholder="PNS" fgroup-class="col-md-6" required />
					</div>
					<div class="row">
						<x-adminlte-select2 name="pendidikan_ibu" fgroup-class="col-md-6" label="Pendidikan Terakhir">
							<x-slot name="prependSlot_ibu">
								<div class="input-group-text bg-gradient-info">
									<i class="fas fa-school"></i>
								</div>
							</x-slot>
							<option value="SD/Sederajat">SD/Sederajat</option>
							<option value="SMP/Sederajat">SMP/Sederajat</option>
							<option value="SMA/Sederajat">SMA/Sederajat</option>
							<option value="D1">D1</option>
							<option value="D2">D2</option>
							<option value="D3">D3</option>
							<option value="D4/S1">D4/S1</option>
							<option value="S2">S2</option>
							<option value="S3">S3</option>
							<option value="Tidak Bersekolah">Tidak Bersekolah</option>
						</x-adminlte-select2>
						<x-adminlte-input name="penghasilan_ibu" label="Penghasilan Perbulan" placeholder="124155151" type="number" fgroup-class="col-md-6" required />
					</div>
					<div class="row">
						<x-adminlte-input name="no_hp_ibu" label="Nomor Handphone/Telp" placeholder="08123456789" type="text" fgroup-class="col-md-6" required />
						<x-adminlte-textarea name="alamat_ibu" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat" />
					</div>
				</x-adminlte-card>
			</div>
			<div class="col-md-6">
				<x-adminlte-card theme="lightblue" theme-mode="outline" title="Isi Data Wali">
					<div class="row">
						<x-adminlte-select2 name="jeniswali" fgroup-class="col-md-6" label="Jenis Wali">
							<x-slot name="prependSlot_ayah">
								<div class="input-group-text bg-gradient-info">
									<i class="fas fa-school"></i>
								</div>
							</x-slot>
							<option value="Ayah Kandung">Ayah Kandung</option>
							<option value="Ibu Kandung">Ibu Kandung</option>
							<option value="Lainnya">Lainnya</option>
						</x-adminlte-select2>
						<!-- <x-adminlte-input name="jeniswali" label="Jenis Wali" placeholder="Ayah" fgroup-class="col-md-6" required /> -->
						<x-adminlte-input name="nama_wali" label="Nama" placeholder="Alfa" fgroup-class="col-md-6" value="-" />
					</div>
					<div class="row">
						<x-adminlte-textarea name="keterangan" fgroup-class="col-md-6" label="Keterangan" placeholder="Keterangan">-</x-adminlte-textarea>
						<x-adminlte-textarea name="alamat_wali" value="-" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat">-</x-adminlte-textarea>
					</div>
					<!-- <div class="row">
						<x-adminlte-input name="tempat_lahir_wali" label="Tempat Lahir" placeholder="Semarang" fgroup-class="col-md-6" value="-" />
						<x-adminlte-input-date name="tanggal_lahir_wali" :config="$config_date" label="Tanggal Lahir" value="2022-04-18" placeholder="Choose a time..." fgroup-class="col-md-6">
							<x-slot name="prependSlot_wali">
								<div class="input-group-text bg-gradient-info">
									<i class="fas fa-clock"></i>
								</div>
							</x-slot>
						</x-adminlte-input-date>
					</div> -->
					<!-- <div class="row">
						<x-adminlte-select2 name="pendidikan_wali" fgroup-class="col-md-6" label="Pendidikan Terakhir">
							<x-slot name="prependSlot_wali">
								<div class="input-group-text bg-gradient-info">
									<i class="fas fa-school"></i>
								</div>
							</x-slot>
							<option value="SD/Sederajat">SD/Sederajat</option>
							<option value="SMP/Sederajat">SMP/Sederajat</option>
							<option value="SMA/Sederajat">SMA/Sederajat</option>
							<option value="D1">D1</option>
							<option value="D2">D2</option>
							<option value="D3">D3</option>
							<option value="D4/S1">D4/S1</option>
							<option value="S2">S2</option>
							<option value="S3">S3</option>
							<option value="Tidak Bersekolah">Tidak Bersekolah</option>
						</x-adminlte-select2>
						<x-adminlte-input name="pekerjaan_wali" value="-" label="Pekerjaan" placeholder="PNS" fgroup-class="col-md-6" />
					</div> -->
					<!-- <div class="row">
						<x-adminlte-input name="penghasilan_wali" value="-" label="Penghasilan Perbulan" placeholder="124155151" type="number" fgroup-class="col-md-4" />
					</div> -->
					<div class="row">
						<x-adminlte-input name="no_hp_wali" value="-" label="Nomor Handphone/Telp" placeholder="08123456789" type="text" fgroup-class="col-md-6" />
					</div>
				</x-adminlte-card>
			</div>
			<div class="col-md-6">
				<x-adminlte-card theme="lightblue" theme-mode="outline" title="No KKS/PKH">
					<div class="row">
						<x-adminlte-input name="nomor_kks" value="0" label="Nomor KKS" placeholder="124155151" type="number" fgroup-class="col-md-4" />
						<x-adminlte-input name="nomor_pkh" value="0" label="Nomor PKH" placeholder="124155151" type="number" fgroup-class="col-md-4" />
					</div>
				</x-adminlte-card>
				<x-adminlte-modal id="modalCustom" title="Konfirmasi Simpan" size="lg" theme="teal" icon="fas fa-bell" v-centered static-backdrop scrollable>
					<div>Apakah Anda yakin untuk menyimpan data?</div>
					<x-slot name="footerSlot">
						<x-adminlte-button theme="danger" label="Tidak" data-dismiss="modal" />
						<x-adminlte-button class="btn-flat" type="submit" label="Ya" theme="success" />
					</x-slot>
				</x-adminlte-modal>
				<x-adminlte-button label="Simpan" data-toggle="modal" theme="success" data-target="#modalCustom" class="btn-flat" />
			</div>
		</div>

	</x-form>
</x-app-layout>
