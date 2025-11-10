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
                $data['announcements'] = $announcementModel->getAll(5);
            }
        } else {
            $title = 'Selamat Datang di Kosan Kami!';
        }
        $data['title'] = $title;
        $this->view('home/index', $data);
    }
}