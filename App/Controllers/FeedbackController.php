<?php

class FeedbackController extends Controller
{
    private $feedbackModel;
    public function __construct()
    {
        Auth::protect();
        Auth::protectRole('penghuni');
        $this->feedbackModel = new Feedback();
    }
    public function create()
    {
        $data = [
            'title' => 'Kirim Kritik & Saran',
            'errors' => [],
            'old' => []
        ];
        $this->view('Feedbacks/create', $data);
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?c=feedback&a=create');
        }
        $data = [
            'user_id' => Auth::userId(),
            'subjek' => $_POST['subjek'] ?? '',
            'isi_pesan' => $_POST['isi_pesan'] ?? ''
        ];
        $validator = new Validator();
        $rules = [
            'subjek' => 'required',
            'isi_pesan' => 'required'
        ];
        if (!$validator->validate($data, $rules)) {
            $viewData = [
                'title' => 'Kirim Kritik & Saran',
                'errors' => $validator->getErrors(),
                'old' => $_POST
            ];
            $this->view('Feedbacks/create', $viewData);
            return;
        }
        $this->feedbackModel->create($data);
        Log::record(Auth::userId(), 'Mengirim feedback baru dengan subjek: ' . $data['subjek']);
        $this->flash('success', 'Kritik & Saran Anda telah berhasil dikirim. Terima kasih.');
        $this->redirect('index.php?c=home&a=index');
    }
}