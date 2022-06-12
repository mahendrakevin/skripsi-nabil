@section('plugins.Select2', true)
<x-app-layout title="Tambah Guru">
	<x-form method="POST" action="{{ route('admin.guru.store') }}">
		<x-adminlte-card theme="lime" theme-mode="outline" title="Isi Data Guru">
			<div class="row">
				<x-adminlte-input name="nama_guru" label="Nama Guru" placeholder="Annisa" fgroup-class="col-md-12" required />
			</div>
			<div class="row">
				<x-adminlte-input name="tempat_lahir" label="Tempat Lahir" placeholder="Semarang" fgroup-class="col-md-6" required />
				<x-adminlte-input-date name="tanggal_lahir" :config="$config_date" label="Tanggal Lahir" placeholder="Choose a time..." fgroup-class="col-md-6" required>
					<x-slot name="prependSlot">
						<div class="input-group-text bg-gradient-info">
							<i class="fas fa-clock"></i>
						</div>
					</x-slot>
				</x-adminlte-input-date>
			</div>
			<div class="row">
				<x-adminlte-input name="nip" label="NIP" placeholder="1277471818" fgroup-class="col-md-4" type="number" required />
				<x-adminlte-input name="nuptk" label="NUPTK" placeholder="1234567890123456" fgroup-class="col-md-4" type="number" />
				<x-adminlte-input name="nik" label="NIK" placeholder="1234567890123456" fgroup-class="col-md-4" type="number" required />
			</div>
			<div class="row">
				<x-adminlte-select2 name="status_perkawinan" fgroup-class="col-md-6" label="Status Pernikahan">
					<x-slot name="prependSlot">
						<div class="input-group-text bg-gradient-info">
							<i class="fas fa-align-justify"></i>
						</div>
					</x-slot>
					<option value="Belum Menikah">Belum Menikah</option>
					<option value="Menikah">Menikah</option>
					<option value="Cerai Hidup">Cerai Hidup</option>
					<option value="Cerai Mati">Cerai Mati</option>
				</x-adminlte-select2>
				<x-adminlte-select2 name="jenis_kelamin" fgroup-class="col-md-6" label="Jenis Kelamin">
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
				<x-adminlte-input name="no_hp" label="Nomor Handphone/Telp" placeholder="08123456789" type="number" fgroup-class="col-md-6" required />
				<x-adminlte-input name="email" label="Email" placeholder="Annisa@gmail.com" type="email" fgroup-class="col-md-6" required />
			</div>
			<div class="row">
				<x-adminlte-textarea name="alamat" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat" />
				<x-adminlte-select2 name="status_pegawai" fgroup-class="col-md-6" label="Status Kepegawaian">
					<x-slot name="prependSlot">
						<div class="input-group-text bg-gradient-info">
							<i class="fas fa-school"></i>
						</div>
					</x-slot>
					<option value="Aktif">Aktif</option>
					<option value="Tidak Aktif">Tidak Aktif</option>
				</x-adminlte-select2>
			</div>
			<!-- <x-adminlte-card theme="lightblue" theme-mode="outline" title="Isi Data Kepegawaian">
			<div class="row">
				<x-adminlte-select2 name="status_pegawai" fgroup-class="col-md-6" label="Status Kepegawaian">
					<x-slot name="prependSlot">
						<div class="input-group-text bg-gradient-info">
							<i class="fas fa-school"></i>
						</div>
					</x-slot>
					<option value="Aktif">Aktif</option>
					<option value="Tidak Aktif">Tidak Aktif</option>
				</x-adminlte-select2>
				<x-adminlte-input-date name="tanggal" :config="$config_date" label="Tanggal SK Pengangkatan" placeholder="Choose a time..." fgroup-class="col-md-6" required>
					<x-slot name="prependSlot_ibu">
						<div class="input-group-text bg-gradient-info">
							<i class="fas fa-clock"></i>
						</div>
					</x-slot>
				</x-adminlte-input-date>
				<x-adminlte-input name="no_sk" label="Nomor SK Pengangkatan" placeholder="1277471818" fgroup-class="col-md-6" type="number" required />
				{{-- <x-adminlte-input name="jabatan" label="Nama Jabatan" placeholder="Guru" type="text"--}}
				{{-- fgroup-class="col-md-6" required/>--}}
			</div>
		</x-adminlte-card> -->
			<x-adminlte-modal id="modalCustom" title="Konfirmasi Simpan" size="lg" theme="teal" icon="fas fa-bell" v-centered static-backdrop scrollable>
				<div>Apakah Anda yakin untuk menyimpan data?</div>
				<x-slot name="footerSlot">
					<x-adminlte-button theme="danger" label="Tidak" data-dismiss="modal" />
					<x-adminlte-button class="btn-flat" type="submit" label="Ya" theme="success" />
				</x-slot>
			</x-adminlte-modal>
			<div class="row">
				<div class="col-lg-12" style="text-align: right;">
					<x-adminlte-button label="Simpan" data-toggle="modal" theme="success" data-target="#modalCustom" class="btn-flat" />
				</div>
			</div>
		</x-adminlte-card>
	</x-form>
	<br>
</x-app-layout>
