@section('plugins.Select2', true)
<x-app-layout title="Edit Lembaga">
	<x-form method="GET" action="{{ route('admin.lembaga.update', $lembaga->id) }}">
		<div class="col-md-12">
			<x-adminlte-card theme="info" theme-mode="info" title="Edit Data Lembaga">
				<div class="row">
					<x-adminlte-input name="nama_lembaga" label="Nama Lembaga" placeholder="RA ALFALAH WAHYUREJO" fgroup-class="col-md-6" type="text" value="{{ $lembaga->nama_lembaga }}" required />
					<x-adminlte-input name="akreditasi" label="akreditasi" placeholder="A" fgroup-class="col-md-6" type="text" value="{{ $lembaga->akreditasi }}" required />
				</div>
				<div class="row">
					<x-adminlte-input-date name="tahun_berdiri" :config="$config_date" label="Tanggal Berdiri" placeholder="Choose a time..." value="{{ $lembaga->tahun_berdiri }}" fgroup-class="col-md-6" required>
						<x-slot name="prependSlot">
							<div class="input-group-text bg-gradient-info">
								<i class="fas fa-clock"></i>
							</div>
						</x-slot>
					</x-adminlte-input-date>
					<x-adminlte-input name="no_telp" label="Nomor Telp" placeholder="40" fgroup-class="col-md-6" value="{{ $lembaga->no_telp }}" type="number" required />
				</div>
				<div class="row">
					<x-adminlte-input name="email" label="Email" placeholder="admin@admin.com" fgroup-class="col-md-6" value="{{ $lembaga->email }}" type="email" required />
					<x-adminlte-textarea name="alamat" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat">
						{{ $lembaga->alamat }}
					</x-adminlte-textarea>
				</div>
				<div class="row">
					<x-adminlte-input name="npsn" label="Nomor NPSN" placeholder="40" fgroup-class="col-md-6" type="number" value="{{ $lembaga->npsn }}" required />
					<x-adminlte-input name="nsm" label="Nomor NSM" placeholder="40" fgroup-class="col-md-6" type="number" value="{{ $lembaga->nsm }}" required />
				</div>
				<div class="row">
					<x-adminlte-input name="nomor_surat_operasional" label="Nomor SK Operasional" placeholder="F/240/JK/2022" fgroup-class="col-md-6" value="{{ $sklembaga->nomor_surat_operasional }}" type="text" />
					<x-adminlte-input-date name="tanggal_surat_operasional" value="{{ $sklembaga->tanggal_surat_operasional }}" :config="$config_date" label="Tanggal SK Operasional" placeholder="Choose a time..." fgroup-class="col-md-6">
						<x-slot name="prependSlot">
							<div class="input-group-text bg-gradient-info">
								<i class="fas fa-clock"></i>
							</div>
						</x-slot>
					</x-adminlte-input-date>
				</div>
				<div class="row">
					<x-adminlte-input name="nomor_surat_kemenkumham" value="{{ $sklembaga->nomor_surat_kemenkumham }}" label="Nomor SK Kemenkumham" placeholder="F/240/JK/2022" fgroup-class="col-md-6" type="text" />
					<x-adminlte-input-date name="tanggal_surat_kemenkumham" value="{{ $sklembaga->tanggal_surat_kemenkumham }}" :config="$config_date" label="Tanggal SK Kemenkumham" placeholder="Choose a time..." fgroup-class="col-md-6">
						<x-slot name="prependSlot">
							<div class="input-group-text bg-gradient-info">
								<i class="fas fa-clock"></i>
							</div>
						</x-slot>
					</x-adminlte-input-date>
				</div>
			</x-adminlte-card>
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
		</div>
		<br>
	</x-form>
</x-app-layout>