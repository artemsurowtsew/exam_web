<?php

class Card {
    // Поля класу є закритими 
    private string $bookTitle;
    private string $authorName;
    private int $copiesIssued;
    private DateTime $issueDate;
    private ?DateTime $returnDate; // Дата повернення буде null, якщо книга ще не повернена

    // Конструктор для ініціалізації об'єкта
    public function __construct(string $bookTitle, string $authorName, int $copiesIssued, string $issueDate, ?string $returnDate = null) {
        $this->bookTitle = $bookTitle;
        $this->authorName = $authorName;
        $this->copiesIssued = $copiesIssued;
        try {
            $this->issueDate = new DateTime($issueDate);
        } catch (Exception $e) {
            echo "Помилка у форматі дати видачі для книги '{$bookTitle}': " . $e->getMessage() . "\n";
            exit;
        }
        $this->returnDate = $returnDate ? new DateTime($returnDate) : null;

        echo "Об'єкт книги '{$this->bookTitle}' створено.\n";
        echo "<br><br>";
    }

    // Деструктор для повідомлення про видалення об'єкта
    public function __destruct() {
        echo "Об'єкт книги '{$this->bookTitle}' видалено.\n";
    }

    //  метод для підрахунку кількості днів, які книга знаходиться на руках
    public function getDaysOnLoan(): int {
        $endDate = $this->returnDate ?? new DateTime(); // Використовуємо поточну дату, якщо книгу не повернули
        $interval = $this->issueDate->diff($endDate);
        return $interval->days;
    }

    // метод для виведення всіх даних про книгу
    public function displayInfo(): void {
        echo "\nНазва книги: {$this->bookTitle}\n";
        echo "Автор: {$this->authorName}\n";
        echo "Кількість виданих примірників: {$this->copiesIssued}\n";
        echo "Дата видачі: " . $this->issueDate->format('Y-m-d') . "\n";
        echo "Дата повернення: " . ($this->returnDate ? $this->returnDate->format('Y-m-d') : 'Книга ще не повернена') . "\n";
        echo "Днів на руках: " . $this->getDaysOnLoan() . "\n";
        echo "<br><br>";
    }
}

$books = [
    new Card("Ніцше. Самоперевершення", "Тарас Лютий", 1, "2024-12-01", "2024-12-25"),
    new Card("Про Свободу", "Тімоті Снайдер", 12, "2024-11-01", null),
    new Card("Хаос в Кремнієвій долині", "Антоніо Гарсіа", 5, "2024-01-15",  "2024-02-25") 
];

//Інформації про всі книги
foreach ($books as $card) {
    $card->displayInfo();
}

//деструктор
unset($books);
echo "<br><br>";

?>
