<?php

namespace App\Controllers;

use App\Models\AboutModel;

class Pages extends BaseController
{
    protected $aboutModel;
    public function __construct()
    {
        $this->aboutModel = new AboutModel();
    }

    public function index()
    {
        $about = $this->aboutModel->findAll();

        $data = [
            'title' => 'About Me',
            'about' =>  $this->aboutModel->getAbout()
        ];

        return view('pages/home', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Author',
            'about' => $this->aboutModel->getAbout($slug)
        ];

        // cek author di database

        if (empty($data['about'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Author ' . $slug . 'tidak Ada');
        }

        return view('pages/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Form Tambah Data Author',
            'validation' => \Config\Services::validation()
        ];

        return view('pages/create', $data);
    }

    public function save()
    {

        // validation input
        if (!$this->validate([
            'nama' => [
                'rules' => 'required|is_unique[about.nama]',
                'errors' => [
                    'is_unique' => '*{field} author sudah ada, silahkan gunakan nama lain.',
                    'requred' => '*{field} author kosong, silahkan isi terlebih dahulu.'
                ]
            ],
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Upload file gambar saja',
                    'mime_in' => 'Upload file gambar saja'

                ]
            ]
        ])) {

            // $validation = \Config\Services::validation();
            // return redirect()->to('/pages/create')->withInput()->with('validation', $validation);
            return redirect()->to('/pages/create')->withInput();
        }
        // kelola gambar
        $fileGambar = $this->request->getFile('gambar');
        // check gambar kosong saat diinput berikan gambar default
        if ($fileGambar->getError() == 4) {
            $namaGambar = 'default.jpg';
        } else {
            // generate nama random
            $namaGambar = $fileGambar->getRandomName();
            // move file ke folder img
            $fileGambar->move('asset/img', $namaGambar);
        }


        $slug = url_title($this->request->getVar('nama'), '-', true);

        $this->aboutModel->save([
            'nama' => $this->request->getVar('nama'),
            'slug' => $slug,
            'bio' => $this->request->getVar('bio'),
            'gambar' => $namaGambar

        ]);

        session()->setFlashdata('pesan', 'Data berhasil disimpan.');

        return redirect()->to('/');
    }

    public function delete($id)
    {
        // cara gambar berdasarkan nama random
        $about = $this->aboutModel->find($id);

        // cek gambar default agar tidak terhapus
        if ($about['gambar'] != 'default.jpg') {
            // delete gambar
            unlink('asset/img/' . $about['gambar']);
        }
        $this->aboutModel->delete($id);

        session()->setFlashdata('pesan', 'Author berhasil dihapus.');

        return redirect()->to('/');
    }
    public function edit($slug)
    {
        $data = [
            'title' => 'Form Edit Data Author',
            'validation' => \Config\Services::validation(),
            'about' => $this->aboutModel->getAbout($slug)
        ];

        return view('pages/edit', $data);
    }

    public function update($id)
    {
        // dd($this->request->getVar());
        // cek judul
        $aboutLama = $this->aboutModel->getAbout($this->request->getVar('slug'));

        if ($aboutLama['nama'] == $this->request->getVar('nama')) {
            $rule_nama = 'required';
        } else {
            $rule_nama = 'required|is_unique[about.nama]';
        }

        // validation input
        if (!$this->validate([
            'nama' => [
                'rules' => $rule_nama,
                'errors' => [
                    'is_unique' => '*{field} author sudah ada, silahkan gunakan nama lain.',
                    'requred' => '*{field} author kosong, silahkan isi terlebih dahulu.'
                ]
            ],
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Upload file gambar saja',
                    'mime_in' => 'Upload file gambar saja'

                ]
            ]
        ])) {

            return redirect()->to('/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $fileGambar = $this->request->getFile('gambar');

        // cek gambar apakah berubah atau tidak

        if ($fileGambar->getError() == 4) {
            $namaGambar = $this->request->getVar('gambarLama');
        } else {
            // generate nama file random
            $namaGambar = $fileGambar->getRandomName();
            // pindahkan gambar ke dalam server
            $fileGambar->move('asset/img/', $namaGambar);
            //delete file lama agar tidak penuh 
            unlink('asset/img/' . $this->request->getVar('gambarLama'));
        }

        $slug = url_title($this->request->getVar('nama'), '-', true);

        $this->aboutModel->save([
            'id' => $id,
            'nama' => $this->request->getVar('nama'),
            'slug' => $slug,
            'bio' => $this->request->getVar('bio'),
            'gambar' => $namaGambar

        ]);

        session()->setFlashdata('pesan', 'Data berhasil disimpan.');
        return redirect()->to('/');
    }


    //--------------------------------------------------------------------

}
