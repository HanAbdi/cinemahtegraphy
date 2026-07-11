<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioForm extends Component
{
    use WithFileUploads;

    public $portfolio_id, $title, $category, $client, $year, $video_url, $description, $service_type, $image, $tags;
    
    public $project_scope = "";
    public $tag_scheme = "A";
    
    public $old_image; 

    public function mount($id = null)
    {
        if ($id) {
            $portfolio = Portfolio::findOrFail($id);
            $this->portfolio_id = $id;
            $this->title = $portfolio->title;
            $this->category = $portfolio->category;
            $this->client = $portfolio->client;
            $this->year = $portfolio->year;
            $this->video_url = $portfolio->video_url;
            $this->description = $portfolio->description;
            $this->service_type = $portfolio->service_type;
            $this->tags = $portfolio->tags ? implode(", ", $portfolio->tags) : "";
            $this->old_image = $portfolio->image_path;
            
            $this->project_scope = $portfolio->project_scope;
            $this->tag_scheme = $portfolio->tag_scheme ?? "A";
        } else {
            $this->year = date("Y");
        }
    }

    public function save()
    {
        $this->validate([
            "title" => "required|string|max:255",
            "category" => "required|string|max:255",
            "client" => "required|string|max:255",
            "year" => "required|integer",
            "description" => "required|string",
            "service_type" => "required|string|max:255",
            "image" => $this->portfolio_id ? "nullable|image" : "required|image",
            "project_scope" => "nullable|string|max:20",
        ]);

        $imagePath = $this->old_image;
        if ($this->image) {
            if ($this->old_image && Storage::disk("public")->exists($this->old_image)) {
                Storage::disk("public")->delete($this->old_image);
            }
            
            $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $img = $manager->read($this->image->getRealPath());
            
            $quality = 90;
            $encoded = $img->toWebp($quality);
            
            // Loop to compress if size > 2MB (2000000 bytes)
            while (strlen($encoded->toString()) > 2000000 && $quality > 10) {
                $quality -= 10;
                $encoded = $img->toWebp($quality);
            }
            
            // If still over 2MB, resize it down to max width 1920
            if (strlen($encoded->toString()) > 2000000) {
                $img->scaleDown(width: 1920);
                $quality = 80;
                $encoded = $img->toWebp($quality);
                while (strlen($encoded->toString()) > 2000000 && $quality > 10) {
                    $quality -= 10;
                    $encoded = $img->toWebp($quality);
                }
            }

            $filename = 'portfolios/' . Str::uuid() . '.webp';
            Storage::disk("public")->put($filename, $encoded->toString());
            $imagePath = $filename;
        }

        $tagsArray = $this->tags ? array_map("trim", explode(",", $this->tags)) : [];

        $processed_video_url = $this->video_url;
        if ($processed_video_url) {
            // YouTube
            if (preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $processed_video_url, $matches)) {
                $processed_video_url = 'https://www.youtube.com/embed/' . $matches[1];
            } elseif (preg_match('/youtu\\.be\\/([^\\?\\&]+)/', $processed_video_url, $matches)) {
                $processed_video_url = 'https://www.youtube.com/embed/' . $matches[1];
            } 
            // Vimeo (e.g. https://vimeo.com/123456789)
            elseif (preg_match('/vimeo\\.com\\/(\\d+)/', $processed_video_url, $matches)) {
                $processed_video_url = 'https://player.vimeo.com/video/' . $matches[1];
            }
            // Google Drive (e.g. https://drive.google.com/file/d/FILE_ID/view)
            elseif (preg_match('/drive\\.google\\.com\\/file\\/d\\/([a-zA-Z0-9_-]+)/', $processed_video_url, $matches)) {
                $processed_video_url = 'https://drive.google.com/file/d/' . $matches[1] . '/preview';
            }
            // Mega.nz (e.g. https://mega.nz/file/ID#KEY)
            elseif (preg_match('/mega\\.nz\\/(file|folder)\\/([^\\s]+)/', $processed_video_url, $matches)) {
                $processed_video_url = 'https://mega.nz/embed/' . $matches[2];
            }
        }

        $isNew = empty($this->portfolio_id);
        $portfolio = Portfolio::updateOrCreate(
            ["id" => $this->portfolio_id],
            [
                "title" => $this->title,
                "slug" => Str::slug($this->title),
                "category" => $this->category,
                "client" => $this->client,
                "year" => $this->year,
                "video_url" => $processed_video_url,
                "description" => $this->description,
                "service_type" => $this->service_type,
                "image_path" => $imagePath,
                "tags" => $tagsArray,
                "project_scope" => $this->project_scope,
                "tag_scheme" => $this->tag_scheme,
            ]
        );

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $isNew ? 'created' : 'updated',
            'model_type' => 'Portfolio',
            'model_id' => $portfolio->id,
            'description' => ($isNew ? 'Menambahkan' : 'Memperbarui') . " portofolio: {$portfolio->title}",
        ]);

        return redirect()->route("admin.portfolios.index");
    }

    public function render()
    {
        return view("livewire.portfolio-form")->layout("components.admin-layout");
    }
}

