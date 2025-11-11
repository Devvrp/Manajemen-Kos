<?php

class HomeController extends Controller
{
    public function index()
    {
        $data = [];
        if (Auth::isLoggedIn()) {
            $title = 'Selamat Datang, ' . htmlspecialchars(Auth::userName()) . '!';
            if (Auth::checkRole('penghuni')) {
                $announcementModel = new Announcement();
                $contractModel = new Contract();
                $contract = $contractModel->getActiveContractByUserId(Auth::userId());
                $branch_id = $contract['branch_id'] ?? null;
                $data['announcements'] = $announcementModel->getAll($branch_id, 5);
            }
        } else {
            $title = 'Selamat Datang di Kosan Kami!';
        }
        $data['title'] = $title;
        $this->view('Home/index', $data);
    }
}