<?php
/**
 * Description of Imaging
 *
 * @author Kaiste
 */
class Imaging {
    // Variables 
    private $input; 
    private $output; 
    private $src; 
    private $format; 
    private $quality = 80; 
    private $xInput; 
    private $yInput; 
    private $xOutput; 
    private $yOutput; 
    private $resize; 

    // Set image 
    public function setImage($img)  { 
        // Find format 
        $ext = strtoupper(pathinfo($img, PATHINFO_EXTENSION)); 
        // JPEG image 
        if(is_file($img) && ($ext == "JPG" OR $ext == "JPEG")) { 
            $this->format = $ext; 
            $this->input = ImageCreateFromJPEG($img); 
            $this->src = $img; 
        } 
        // PNG image 
        elseif(is_file($img) && $ext == "PNG") { 
            $this->format = $ext; 
            $this->input = ImageCreateFromPNG($img); 
            $this->src = $img; 
        } 
        // GIF image 
        elseif(is_file($img) && $ext == "GIF") { 
            $this->format = $ext; 
            $this->input = ImageCreateFromGIF($img); 
            $this->src = $img; 
        } 
        // Get dimensions 
        $this->xInput = imagesx($this->input); 
        $this->yInput = imagesy($this->input); 
    } 

    // Set maximum image size (pixels) 
    public function setSize($max_x = 100,$max_y = 100) { 
        // Resize 
        if($this->xInput > $max_x || $this->yInput > $max_y) { 
            $a= $max_x / $max_y; 
            $b= $this->xInput / $this->yInput; 
            if ($a<$b) { 
                $this->xOutput = $max_x; 
                $this->yOutput = ($max_x / $this->xInput) * $this->yInput; 
            } 
            else { 
                $this->yOutput = $max_y; 
                $this->xOutput = ($max_y / $this->yInput) * $this->xInput; 
            } 
            // Ready 
            $this->resize = TRUE; 
        } 
        // Don't resize       
        else { $this->resize = FALSE; } 
    } 
    
    // Set image quality (JPEG only) 
    public function setQuality($quality) { 
        if(is_int($quality)) 
        { 
            $this->quality = $quality; 
        } 
    } 
    
    // Save image 
    public function saveImg($path) { 
        // Resize 
        if($this->resize) 
        { 
            $this->output = ImageCreateTrueColor($this->xOutput, $this->yOutput); 
            ImageCopyResampled($this->output, $this->input, 0, 0, 0, 0, $this->xOutput, $this->yOutput, $this->xInput, $this->yInput); 
        } 
        // Save JPEG 
        if($this->format == "JPG" OR $this->format == "JPEG") 
        { 
            if($this->resize) { imageJPEG($this->output, $path, $this->quality); } 
            else { copy($this->src, $path); } 
        } 
        // Save PNG 
        elseif($this->format == "PNG") 
        { 
            if($this->resize) { imagePNG($this->output, $path); } 
            else { copy($this->src, $path); } 
        } 
        // Save GIF 
        elseif($this->format == "GIF") 
        { 
            if($this->resize) { imageGIF($this->output, $path); } 
            else { copy($this->src, $path); } 
        } 
    } 
    
    // Get width 
    public function getWidth() {  return $this->xInput;  } 
    
    // Get height 
    public function getHeight() {  return $this->yInput;  } 
    
    // Clear image cache 
    public function clearCache() {  @ImageDestroy($this->input);  @ImageDestroy($this->output);  } 
} 
