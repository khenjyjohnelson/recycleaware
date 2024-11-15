<?php
defined('BASEPATH') or exit('No direct script access allowed');

include 'Omnitags.php';

class C_tabel_b2 extends Omnitags
{
	// Pages
	// Public Pages
	public function detail($param1 = null)
	{
		$this->declarew();
		$this->page_session_all();

		$tabel = $this->tl_b2->get_b2_by_b2_field1($param1)->result();
		$this->check_data($tabel);

		$data1 = array(
			'title' => lang('tabel_b2_alias_v8_title'),
			'konten' => $this->v8['tabel_b2'],
			'dekor' => $this->tl_b1->dekor($this->theme_id, $this->aliases['tabel_b2']),
			'tbl_b2' => $this->tl_b2->get_b2_by_b2_field1($param1),
		);

		$data = array_merge($data1, $this->package);

		set_userdata('previous_url', current_url());
		load_view_data('_layouts/template', $data);
	}


	// Account Only Pages


	// Admin Pages
	public function admin()
	{
		$this->declarew();
		$this->page_session_3();

		$param1 = $this->v_get['tabel_b2_field7'];

		$filter = $this->tl_b2->filter($param1);

		if (empty($param1)) {
			$result = $this->tl_b2->get_all_b2();
		} else {
			$result = $filter;
		}

		$data1 = array(
			'title' => lang('tabel_b2_alias_v3_title'),
			'konten' => $this->v3['tabel_b2'],
			'dekor' => $this->tl_b1->dekor($this->theme_id, $this->aliases['tabel_b2']),
			'tbl_b2' => $result,
			'tbl_b7' => $this->tl_b7->get_all_b7(),
			'tabel_b2_field7_value' => $param1
		);

		$data = array_merge($data1, $this->package);

		set_userdata('previous_url', current_url());
		load_view_data('_layouts/template', $data);
	}

	// Print all data
	public function laporan()
	{
		$this->declarew();
		$this->page_session_3();

		$data1 = array(
			'title' => lang('tabel_b2_alias_v4_title'),
			'konten' => $this->v4['tabel_b2'],
			'dekor' => $this->tl_b1->dekor($this->theme_id, $this->aliases['tabel_b2']),
			'tbl_b2' => $this->tl_b2->get_all_b2(),
		);

		$data = array_merge($data1, $this->package);

		set_userdata('previous_url', current_url());
		load_view_data('_layouts/printpage', $data);
	}

	// Functions
	// Add data
	public function tambah()
	{
		$this->declarew();
		$this->session_3();

		validate_all(
			array(
				$this->v_post['tabel_b2_field2'],
				$this->v_post['tabel_b2_field3'],
				$this->v_post['tabel_b2_field5'],
				$this->v_post['tabel_b2_field7'],
			),
			$this->views['flash2'],
			'tambah'
		);

		$tabel_b2_field2 = $this->v_post['tabel_b2_field2'];
		$method = $this->tl_b2->get_b2_by_b2_field2($tabel_b2_field2);

		// mencari apakah jumlah data kurang dari 1
		if ($method->num_rows() < 1) {

			$new_name = $this->v_post['tabel_b2_field2'];
			$path = $this->v_upload_path['tabel_b2'];

			$config['upload_path'] = $path;
			$config['allowed_types'] = $this->file_type1;
			$config['file_name'] = $new_name;
			$config['overwrite'] = TRUE;
			$config['remove_spaces'] = TRUE;

			$this->load->library('upload', $config);
			$upload = $this->upload->do_upload($this->v_input['tabel_b2_field4_input']);

			if (!$upload) {
				// Di sini seharusnya ada notifikasi modal kalau upload tidak berhasil
				// Tapi karena formnya sudah required saya rasa tidak perlu
				set_flashdata($this->views['flash2'], $this->flash_msg2['tabel_b2_field4_alias']);
				set_flashdata('modal', $this->views['flash2_func1']);
				redirect($_SERVER['HTTP_REFERER']);
			} else {
				// Di bawah ini adalah method untuk mengambil informasi dari hasil upload data
				$upload = $this->upload->data();
				$gambar = $upload['file_name'];
			}

			// $id = get_next_code($this->aliases['tabel_e1'], $this->aliases['tabel_e1_field1'], 'FK');
			// $this->aliases['tabel_e1_field1'] => $id,

			$data = array(
				$this->aliases['tabel_b2_field1'] => '',
				$this->aliases['tabel_b2_field2'] => $this->v_post['tabel_b2_field2'],
				$this->aliases['tabel_b2_field3'] => $this->v_post['tabel_b2_field3'],
				$this->aliases['tabel_b2_field4'] => $gambar,
				$this->aliases['tabel_b2_field5'] => htmlspecialchars($this->v_post['tabel_b2_field5']),
				$this->aliases['tabel_b2_field6'] => $this->aliases['tabel_b2_field6_value2'],
				$this->aliases['tabel_b2_field7'] => $this->v_post['tabel_b2_field7'],
			);

			$aksi = $this->tl_b2->insert_b2($data);

			$notif = $this->handle_4b($aksi, 'tabel_b2');

			redirect(site_url($this->language_code . '/' . $this->aliases['tabel_b2'] . '/admin'));
		} else {
			set_flashdata($this->views['flash1'], $this->aliases['tabel_b2_field2'] . ' telah digunakan!');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	// Update data
	public function update()
	{
		$this->declarew();
		$this->session_3();

		$tabel_b2_field1 = $this->v_post['tabel_b2_field1'];

		$tabel = $this->tl_b2->get_b2_by_b2_field1($tabel_b2_field1)->result();
		$this->check_data($tabel);

		validate_all(
			array(
				$this->v_post['tabel_b2_field1'],
				$this->v_post['tabel_b2_field2'],
				$this->v_post['tabel_b2_field3'],
				$this->v_post['tabel_b2_field4_old'],
				$this->v_post['tabel_b2_field5'],
				$this->v_post['tabel_b2_field7'],
			),
			$this->views['flash3'],
			'ubah' . $tabel_b2_field1,
		);

		$tabel_b2 = $this->tl_b2->get_b2_by_b2_field1($tabel_b2_field1)->result();
		$new_name = $this->v_post['tabel_b2_field2'];
		$path = $this->v_upload_path['tabel_b2'];
		$img = $this->v_post['tabel_b2_field4_old'];
		$extension = '.' . getExtension($path . $img);

		$config['upload_path'] = $path;
		// nama file telah ditetapkan dan hanya berekstensi jpg dan dapat diganti dengan file bernama sama
		$config['file_name'] = $new_name;
		$config['allowed_types'] = $this->file_type1;
		$config['overwrite'] = TRUE;
		$config['remove_spaces'] = TRUE;

		$this->load->library('upload', $config);
		$upload = $this->upload->do_upload($this->v_input['tabel_b2_field4_input']);

		if (!$upload) {
			if ($new_name != $tabel_b2[0]->nama) {
				rename($path . $img, $path . str_replace(' ', '_', $new_name) . $extension);
				$gambar = str_replace(' ', '_', $new_name) . $extension;
			} else {
				$gambar = $img;
			}
		} else {
			if ($new_name != $tabel_b2[0]->nama) {
				// File upload is successful, delete the old file
				if (file_exists($path . $img)) {
					unlink($path . $img);
				}
				$upload = $this->upload->data();
				$gambar = $upload['file_name'];
			} else {
				$gambar = $img;
			}
		}

		// menggunakan nama khusus sama dengan konfigurasi
		$data = array(
			$this->aliases['tabel_b2_field2'] => $new_name,
			$this->aliases['tabel_b2_field3'] => $this->v_post['tabel_b2_field3'],
			$this->aliases['tabel_b2_field4'] => $gambar,
			$this->aliases['tabel_b2_field5'] => $this->v_post['tabel_b2_field5'],
			$this->aliases['tabel_b2_field7'] => $this->v_post['tabel_b2_field7'],
		);

		$aksi = $this->tl_b2->update_b2($data, $tabel_b2_field1);

		$notif = $this->handle_4c($aksi, 'tabel_b2', $tabel_b2_field1);

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function aktifkan($tabel_b2_field1 = null) //update tidak diperlukan di sini
	{
		$this->declarew();
		$this->session_3();

		$tabel = $this->tl_b2->get_b2_by_b2_field1($tabel_b2_field1)->result();
		$this->check_data($tabel);

		// menggunakan nama khusus sama dengan konfigurasi
		$data = array(
			$this->aliases['tabel_b2_field6'] => $this->aliases['tabel_b2_field6_value1'],
		);

		$aksi = $this->tl_b2->update_b2($data, $tabel_b2_field1);

		$notif = $this->handle_4c($aksi, 'tabel_b2_field6', $tabel_b2_field1);

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function nonaktifkan($tabel_b2_field1 = null) //update tidak diperlukan di sini
	{
		$this->declarew();
		$this->session_3();

		$tabel = $this->tl_b2->get_b2_by_b2_field1($tabel_b2_field1)->result();
		$this->check_data($tabel);

		// menggunakan nama khusus sama dengan konfigurasi
		$data = array(
			$this->aliases['tabel_b2_field6'] => $this->aliases['tabel_b2_field6_value2'],
		);

		$aksi = $this->tl_b2->update_b2($data, $tabel_b2_field1);

		$notif = $this->handle_4c($aksi, 'tabel_b2_field6', $tabel_b2_field1);

		redirect($_SERVER['HTTP_REFERER']);
	}

	// Delete data
	public function delete($tabel_b2_field1 = null)
	{
		$this->declarew();
		$this->session_3();

		$tabel_b2 = $this->tl_b2->get_b2_by_b2_field1($tabel_b2_field1)->result();
		$this->check_data($tabel_b2);

		$img = $tabel_b2[0]->img;

		unlink($this->v_upload_path['tabel_b2'] . $img);

		$aksi = $this->tl_b2->delete_b2($tabel_b2_field1);

		$notif = $this->handle_4e($aksi, 'tabel_b2', $tabel_b2_field1);

		redirect($_SERVER['HTTP_REFERER']);
	}

	// Print one data
}
