<?php

namespace App\Filament\Anggota\Resources\ProfileResource\Pages;

use App\Filament\Anggota\Resources\ProfileResource;
use App\Models\Dpc;
use Filament\Resources\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EditPekerjaan extends Page
{
    protected static string $resource = ProfileResource::class;

    protected static string $view = 'filament.anggota.resources.profile-resource.pages.edit-pekerjaan';

    public ?array $data = [];

    public function mount()
    {
        $pekerjaan = Auth::user()->pekerjaan?->toArray() ?? [];
        $data = [];

        foreach ($pekerjaan as $key => $value) {
            $data[$key] = $value;
        }

        //tambahkan field yang tidak ada di model anggota jika diperlukan
        //$data['field'] = 'value';

        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nik')
                    ->numeric()
                    ->length(16)
                    ->required(),
                Select::make('jenis_instansi')
                    ->label('Jenis Instansi')
                    ->searchable()
                    ->native(false)
                    ->options([
                        'Pusat Kesehatan Masyarakat' => 'Pusat Kesehatan Masyarakat',
                        'RS Swasta' => 'RS Swasta',
                        'Institusi Pendidikan' => 'Institusi Pendidikan',
                        'Klinik Pratama' => 'Klinik Pratama',
                        'RS Pemerintah' => 'RS Pemerintah',
                        'Faskes Pemerintah' => 'Faskes Pemerintah',
                    ]),
                TextInput::make('nama_instansi')->required(),
                TextInput::make('provinsi')->label('Provinsi'),
                TextInput::make('kab_kota'),
                DatePicker::make('awal_kerja')
                    ->native(false),
                Select::make('status')
                    ->label('Status')
                    ->native(false)
                    ->options([
                        'Swasta Kontrak' => 'Swasta Kontrak',
                        'Swasta Tetap' => 'Swasta Tetap',
                        'BLU' => 'BLU',
                    ]),
                Select::make('jabatan')
                    ->searchable()
                    ->native(false)
                    ->options([
                        'Coding' => 'Coding',
                        'Pendaftaran' => 'Pendaftaran',
                        'Casemix' => 'Casemix',
                        'Pengolahan Data' => 'Pengolahan Data',
                        'Dosen' => 'Dosen',
                        'Pelaporan' => 'Pelaporan',
                        'Penyimpanan' => 'Penyimpanan',
                        'Struktural' => 'Struktural',
                        'Lainnya' => 'Lainnya',
                    ]),
                Select::make('domain')
                    ->searchable()
                    ->native(false)
                    ->options([
                        'Utama' => 'Utama',
                        'Kedua' => 'Kedua',
                        'Apotek' => 'Apotek',
                    ]),
                Select::make('dpc')
                    ->label('DPC')
                    ->options(Dpc::pluck('nama_dpc', 'id'))
                    ->searchable(),
                TextInput::make('nip')
                    ->label('NIP'),
                TextInput::make('pangkat'),
                TextInput::make('jabatan_fungsional'),
                TextInput::make('no_sk_jabfung')
                    ->label('No. SK Jabfung'),
                DatePicker::make('tmt_jabfung')
                    ->label('TMT Jabfung'),

            ])->statePath('data');
    }

    public function save()
    {
        return Action::make('save')
            ->label('Simpan')
            ->action('saveData');
    }

    public function cancel()
    {
        return Action::make('cancel')
            ->label('Batal')
            ->outlined()
            ->action(function () {
                return redirect()->route('filament.anggota.resources.profiles.index');
            });
    }

    public function saveData()
    {
        $data = $this->form->getState();
        try {
            DB::beginTransaction();
            /** @var \App\Models\User */
            $user = Auth::user();

            $user->pekerjaan()->updateOrCreate([
                'nik' => $user->nik
            ],$data);
            DB::commit();
            Notification::make('success')
                ->title('Berhasil')
                ->body('Data pekerjaan berhasil disimpan')
                ->success()
                ->send();
                return redirect()->route('filament.anggota.resources.profiles.pekerjaan');
        } catch (\Throwable $th) {
            DB::rollBack();
            Notification::make('error')
                ->title('Gagal')
                ->body(config('app.debug') ? $th->getMessage():'Data pekerjaan gagal disimpan')
                ->danger()
                ->send();
        }
    }
}
