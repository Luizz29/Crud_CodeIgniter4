<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\GenderModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductController extends BaseController
{
    protected $productModel;
    protected $genderModel;
    protected $db;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->genderModel = new GenderModel();
        $this->db = \Config\Database::connect();
        helper(['form']); // Load the form helper
    }
    public function index()
    {
        $data['products'] = $this->productModel->findAll();
        return view('products/index', $data);
    }

    public function loadProducts()
    {
        $products = $this->productModel->findAll();
        return $this->response->setJSON($products);
    }

    public function create()
    {
        return view('products/create');
    }

    public function genderChart()
    {
        $genderData = $this->genderModel->getGender();

        $labels = [];
        $data = [];

        foreach ($genderData as $gender) {
            $labels[] = $gender['jenis'];
            $data[] = $gender['total'];
        }

        $chartData = [
            'labels' => $labels,
            'datasets' => [[
                'data' => $data,
                'backgroundColor' => ['grey', 'black', 'green'],
            ]]
        ];

        // Kirim ke view dalam format JSON
        $data['chartData'] = json_encode($chartData);

        return view('products/gender', $data);
    }

    public function genderChartData()
    {
        $genderData = $this->genderModel->getGender();

        $labels = [];
        $data = [];

        foreach ($genderData as $row) {
            $labels[] = $row['jenis'];
            $data[] = $row['total'];
        }

        $chartData = [
            'labels' => $labels,
            'datasets' => [[
                'data' => $data,
                'backgroundColor' => ['red', 'blue', 'green'],
            ]]
        ];

        return $this->response->setJSON(['status' => true, 'data' => $chartData]);
    }

    public function loadGender()
    {
        $gender = $this->genderModel->getGenderData();

        // Debugging
        return $this->response->setJSON([
            'status' => true,
            'data' => $gender

        ]);
    }
    public function addGender()
    {

        $validation = $this->validate([
            'username' => 'required|min_length[3]|max_length[255]',
            'jenis_kelamin' => 'required|in_list[Laki-laki,Perempuan]',
        ]);
        if (!$validation) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $genderData = [
            'username' => $this->request->getPost('username'),
            'jenis' => $this->request->getPost('jenis_kelamin'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->genderModel->insert($genderData);
        $genderData['id'] = $this->genderModel->getInsertID();

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan!',
            'data' => $genderData,
        ]);
    }

    public function editGender()
    {
        $id = $this->request->getPost('id'); // Ambil ID dari POST
        if (!$id) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID tidak ditemukan!',
            ]);
        }

        $validation = $this->validate([
            'username' => 'required|min_length[3]|max_length[255]',
            'jenis_kelamin' => 'required|in_list[Laki-laki,Perempuan]',
        ]);

        if (!$validation) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $genderData = [
            'username' => $this->request->getPost('username'),
            'jenis' => $this->request->getPost('jenis_kelamin'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->genderModel->update($id, $genderData);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data berhasil diperbarui!',
            'data' => array_merge(['id' => $id], $genderData),
        ]);
    }
    public function bulkDelete()
    {
        $ids = $this->request->getPost('ids'); // Ambil array ID dari AJAX

        if (empty($ids)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tidak ada data yang dipilih!']);
        }

        $this->db->table('gender')->whereIn('id', $ids)->delete(); // Hapus berdasarkan ID

        return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil dihapus!']);
    }

    public function deleteGender($id)
    {
        $deleted = $this->genderModel->delete($id);

        if ($deleted) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Produk berhasil dihapus.',
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Gagal menghapus produk.'
        ]);
    }













    //ENDD
    public function store()
    {
        $validation = $this->validate([
            'name' => 'required|min_length[3]|max_length[255]',
            'price' => 'required|numeric',
            'description' => 'required|min_length[5]',
            'options' => 'permit_empty',
            'condition' => 'required|in_list[New,Used]',
            'category' => 'required',
        ]);

        if (!$validation) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $options = $this->request->getPost('options') ? implode(',', $this->request->getPost('options')) : null;

        $productData = [
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'description' => $this->request->getPost('description'),
            'options' => $options,
            'condition' => $this->request->getPost('condition'),
            'category' => $this->request->getPost('category'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->productModel->insert($productData);
        $productData['id'] = $this->productModel->getInsertID();

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan!',
            'data' => $productData,
        ]);
    }

    public function edit($id)
    {
        $data['product'] = $this->productModel->find($id);
        return view('products/edit', $data);
    }


    public function update()
    {
        $id = $this->request->getPost('id');
        $validation = $this->validate([
            // 'name' => 'required|min_length[3]|max_length[255]',
            'price' => 'required|numeric',
            'description' => 'required|min_length[5]',
            'options' => 'permit_empty',
            'condition' => 'required|in_list[New,Used]',
            'category' => 'required',
        ]);

        if (!$validation) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $options = $this->request->getPost('options') ? implode(',', $this->request->getPost('options')) : null;

        $productData = [
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'description' => $this->request->getPost('description'),
            'options' => $options,
            'condition' => $this->request->getPost('condition'),
            'category' => $this->request->getPost('category'),
        ];

        $this->productModel->update($id, $productData);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Produk berhasil diperbarui!',
            'data' => array_merge(['id' => $id], $productData),
        ]);
    }


    public function delete($id)
    {
        $deleted = $this->productModel->delete($id);

        if ($deleted) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Produk berhasil dihapus.',
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Gagal menghapus produk.'
        ]);
    }
    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        $sheet->setCellValue('A1', 'Name')
            ->setCellValue('B1', 'Price')
            ->setCellValue('C1', 'Description')
            ->setCellValue('D1', 'Condition')
            ->setCellValue('E1', 'Options')
            ->setCellValue('F1', 'Category');


        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->getColumnDimension('C')->setWidth(35);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(35);
        $sheet->getColumnDimension('F')->setWidth(8);

        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        $chunkSize = 200;
        $offset = 0;
        $row = 2;

        while (true) {
            $products = $this->productModel->limit($chunkSize, $offset)->findAll();
            if (empty($products)) {
                break;  //Mengecek apakah data produk yang diambil kosong
            }

            foreach ($products as $product) {
                $sheet->setCellValue('A' . $row, $product['name']);
                $sheet->setCellValue('B' . $row, $product['price']);
                $sheet->setCellValue('C' . $row, $product['description']);
                $sheet->setCellValue('D' . $row, ucfirst($product['condition']));
                $sheet->setCellValue('E' . $row, $product['options']);
                $sheet->setCellValue('F' . $row, $product['category']);
                $row++;
            }

            $offset += $chunkSize;  // Pindah ke chunk berikutnya
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'latihan_chunk.xlsx';


        ob_end_clean();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }



    public function print()
    {
        $data['products'] = $this->productModel->findAll();
        return view('products/print', $data);
    }

    public function search()
    {
        $query = strtolower($this->request->getGet('query'));
        $builder = $this->productModel->builder();


        $builder->like('LOWER(name)', $query);
        $builder->orLike('LOWER(description)', $query);
        $builder->orLike('LOWER(condition)', $query);
        $builder->orLike('LOWER(options)', $query);
        $builder->orLike('LOWER(category)', $query);

        if (is_numeric($query)) {
            $builder->orWhere('price', $query);
        }

        $products = $builder->get()->getResultArray();

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $products,
        ]);
    }


    public function import()
    {
        $file = $this->request->getFile('excelFile');
        if ($file->isValid() && !$file->hasMoved()) {
            $filePath = $file->getTempName();
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = [];
            foreach ($sheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                $rowData = [];
                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }
                $data[] = $rowData;
            }

            $importedData = [];
            // Process the data and insert into the database
            foreach ($data as $row) {
                // Skip the header row
                if ($row[0] === 'Name' && $row[1] === 'Price') {
                    continue;
                }

                // Validate and clean data
                $name = trim($row[0]);
                $price = is_numeric($row[1]) ? (float) $row[1] : 0;
                $description = trim($row[2]);
                $condition = in_array($row[3], ['New', 'Used']) ? $row[3] : 'New';
                $options = trim($row[4]);
                $category = trim($row[5]);

                // Insert data into the database
                $productData = [
                    'name' => $name,
                    'price' => $price,
                    'description' => $description,
                    'condition' => $condition,
                    'options' => $options,
                    'category' => $category,
                ];
                $this->productModel->insert($productData);
                $importedData[] = array_merge(['id' => $this->productModel->insertID()], $productData);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data berhasil diimpor!',
                'data' => $importedData,
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Gagal mengimpor data.',
        ]);
    }
    public function dataTable()
    {
        $data['products'] = $this->productModel->findAll();
        return view('products/data_table', $data);
    }
    public function deleteMultiple()
    {
        $productIds = $this->request->getPost('id'); // Ambil ID produk dari POST

        if ($productIds && is_array($productIds)) {
            $this->productModel->whereIn('id', $productIds)->delete();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Produk berhasil dihapus.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Tidak ada produk yang dipilih untuk dihapus.'
        ]);
    }
    public function exportChunk($offset = 0, $limit = 200)
    {
        $offset = (int) $offset;
        $limit = (int) $limit;
        $products = $this->productModel->limit($limit, $offset)->findAll();
        return $this->response->setJSON($products);
    }

    public function importChunk()
    {
        $this->db->transBegin();
        try {
            $chunk = json_decode($this->request->getPost('chunk'), true);
            $chunkNumber = $this->request->getPost('chunkNumber');
            $totalChunks = $this->request->getPost('totalChunks');


            $data = [];
            foreach ($chunk as $row) {
                $data[] = [
                    'name' => $row['Name'] ?? '',
                    'price' => $row['Price'] ?? 0,
                    'description' => $row['Description'] ?? '',
                    'condition' => $row['Condition'] ?? '',
                    'options' => $row['Options'] ?? '',
                    'category' => $row['Category'] ?? ''
                ];
            }

            if (!empty($data)) {
                $this->productModel->insertBatch($data);
            }

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => 'Database transaction gagal'
                ]);
            }

            $this->db->transComplete();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Chunk ' . ($chunkNumber + 1) . ' of ' . $totalChunks . ' imported successfully',
                'imported_count' => count($data)
            ]);
        } catch (\Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $e->getMessage()
            ]);
        }
    }
}
