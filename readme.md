# **System Settings**
The `Setting` model is used to manage the configuration and customizable options of the application. These settings allow for flexible adjustments without modifying the source code. Each setting includes the following fields:

- **Title:** A unique name for the setting.
- **Description:** Explains the purpose of the setting (optional).
- **Value:** The default value assigned to the setting.
- **Validation:** Rules to validate the value during updates.

---

## 1. Cafe Name  
- **Purpose:** Stores the name of the cafe.  
- **Title:** `Cafe Name`  
- **Description:** The name of the cafe displayed throughout the system.  
- **Value:** Default value is `Cafe`.  
- **Validation:** `required|min:2|max:32`  

---

## 2. Image  
- **Purpose:** Represents an optional image for the cafe.  
- **Title:** `Image`  
- **Description:** An optional logo or banner image for the cafe.  
- **Value:** Default value is `0`.  
- **Validation:** `nullable|image`  

---

## 3. Color  
- **Purpose:** Sets the primary theme color for the application.  
- **Title:** `Color`  
- **Description:** Defines the visual appearance of the interface.  
- **Value:** Default value is `0`.  
- **Validation:** `required|color`  

---

## 4. Description  
- **Purpose:** A description of the cafe for promotional or informational purposes.  
- **Title:** `Description`  
- **Description:** A brief description about your cafe, required for marketing and branding.  
- **Value:** Default value is `0`.  
- **Validation:** `required|min:2|max:64`  

---

## 5. Password  
- **Purpose:** Adds a password for client-requested actions.  
- **Title:** `Password`  
- **Description:** A password used to authorize actions requested by clients.  
- **Value:** Default value is `1234`.  
- **Validation:** `required|min:2|max:32`  

---

## 6. Reset Time  
- **Purpose:** Specifies the reset time for daily sales accounting.  
- **Title:** `Reset Time`  
- **Description:** Time at which the sales data is reset for accounting purposes.  
- **Value:** Default value is `5:00`.  
- **Validation:** `required|time`  

---

## 7. Taxes  
- **Purpose:** Sets the tax percentage applicable to products and services.  
- **Title:** `Taxes`  
- **Description:** Percentage of taxes applied to sales and transactions.  
- **Value:** Default value is `5`.  
- **Validation:** `required|numeric|min:0|max:100`  

---

## 8. Services  
- **Purpose:** Defines the service fee percentage.  
- **Title:** `Services`  
- **Description:** Percentage charged as a service fee on transactions.  
- **Value:** Default value is `10`.  
- **Validation:** `required|numeric|min:0|max:100`  

---

## 9. Max Fixed Discount  
- **Purpose:** Specifies the highest fixed discount allowed.  
- **Title:** `Max Fixed Discount`  
- **Description:** The largest possible fixed discount value you can offer.  
- **Value:** Default value is `0`.  
- **Validation:** `required|numeric|min:0|max:2000000000`  

---

## 10. Max Rate Discount  
- **Purpose:** Sets the maximum percentage discount based on pricing rates.  
- **Title:** `Max Rate Discount`  
- **Description:** The highest discount percentage for price adjustments.  
- **Value:** Default value is `0`.  
- **Validation:** `required|numeric|min:0|max:100`  

---

## 11. Max Item Discount  
- **Purpose:** Determines the maximum discount applied to a single item.  
- **Title:** `Max Item Discount`  
- **Description:** The highest discount percentage or amount available per item.  
- **Value:** Default value is `0`.  
- **Validation:** `required|numeric|min:0|max:2000000000`  

---

### Notes  
- **Password Usage:**  
  The password can be included in any client-requested action to ensure proper authorization. This is useful for securing transactions and sensitive operations.

- **Default Values:**  
  Each setting has a predefined default value. Make sure to customize these as per your system’s specific requirements.

---

## **Model Functions**

### Setting Model (`Setting.php`)

```php
class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'value',
        'validation'
    ];

    // Retrieve the value for a specific setting by title
    public static function get($title)
    {
        return Setting::where('title', $title)->first()->value;
    }

    // Get the value for the 'Taxes' setting
    public static function getTaxes()
    {
        return Setting::where('title', 'Taxes')->first()->value;
    }

    // Get the value for the 'Services' setting
    public static function getServices()
    {
        return Setting::where('title', 'Services')->first()->value;
    }
}
```



# **Admin Settings**
## Subsection: *Item Settings*
This section includes models and relationships for managing menu items, categories, and subcategories. These models help in organizing the items into **Item Types**, **Categories**, and **Subcategories** with relevant images for menu display purposes.


---

## **1. ItemType**  
The **ItemType** model is designed to define the type of items, such as food, beverages, or desserts. Each item type can have an associated image that serves as a visual representation for the menu.

### **Model: `ItemType`**

```php
class ItemType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_ar',
        'title_ku',
        'image'
    ];

    /* Relation Functions */
}
```
Purpose
- Represents different types of items (e.g., food, beverages, desserts).
- Includes an image field that serves as a visual representation on the menu interface.
- Helps in categorizing items logically to improve the overall navigation and user experience.

---

## **2. ItemCategory**  
The **Category** model belongs to an ItemType and helps in organizing items within a specific type. It also has an associated image for menu display purposes.

### **Model: `ItemCategory`**

```php
class ItemCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_type_id',
        'title',
        'title_ar',
        'title_ku',
        'image'
    ];

    /* Relation Functions */
}
```

Purpose
- Acts as a sub-division within an Item Type (e.g., beverages may contain cold drinks, hot drinks).
- Includes an image that is displayed on the menu interface.

---

## **3. Subcategories**  
The **Subcategory** model belongs to a Category and is an optional level of classification. It’s not mandatory but is recommended when the client wants to display menus with three levels of navigation: **Type → Category → Subcategory**.

### **Model: `ItemSubcategory`**

```php
class ItemSubcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_category_id',
        'title',
        'title_ar',
        'title_ku',
        'image'
    ];

    /* Relation Functions */
}
```

Purpose
- Provides a more detailed categorization of products.
- Optional but recommended for menus that include three levels of navigation (Type, Category, Subcategory).
- Includes an image that is displayed on the menu interface.

## Subsection: *Serving Settings*

This section handles critical delivery interactions ensuring timely delivery of orders while maintaining a seamless connection between delivery personnel, dining tables, and orders. It integrates multiple fields to manage the delivery process efficiently.


## **1. Table**  
The Table model represents the tables in a dining or delivery system, including seating capacity and notes for a restaurant or cafe environment. 

### **Model: `Table`**

```php 
class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'chairs',
        'note',
    ];

    // Automatically ensures a placeholder table exists for Takeaway interactions.
    public static function takeAway()
    {
        $table = Table::where('title', '#')->first();

        if (!$table) {
            $table = Table::create([
                'title' => '#',
                'chairs' => 0, 
                'note' => null,
            ]);
        }

        return $table;
    }

    // Counts active invoices for a table interaction
    public function activeInvoicesCount()
    {
        return $this->invoices->where('active', 1)->count();
    }
}
```

Purpose
- **`takeAway()`** function, Creates or fetches a table specifically designated for Takeaway interactions if no Takeaway identifier (#) already exists.
- The **`activeInvoicesCount()`** method returns the number of active invoices associated with a particular table.

## **2. Employee**  

The **`Employee`** model represents the employees who manage tables and serve customers in the system. This model ensures that employees are associated with specific invoices when required, supporting efficient tracking of service responsibilities.

### **Model: `Employee`**

```php

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active'
    ];
}
```

Purpose
- **Employee Assignment**: When a table's invoice (dine-in) requires an employee, this model tracks the employee serving the table.
- **Active Employees**: Only active employees (**`active = true`**) can be assigned to serve tables, ensuring operational efficiency.
- This ensures proper assignment of staff and accountability for table service.

## **3. Payment Method**  

The **`PaymentMethod`** model represents the various payment methods available in the system, such as cash, credit card, or digital payments. This model helps manage and organize the types of payment options offered to customers.

### **Model: `PaymentMethod`**

```php
class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];
}
```

purpose
- The PaymentMethod model is used to list and manage the available payment methods in the system.
- This model is essential for managing payments from customers and recording transaction-related expenses, ensuring accurate and organized financial tracking.

## **4. Delivery Type

The **`DeliveryType`** model represents the various methods by which orders are delivered to customers. This allows the system to handle multiple delivery services and manage their respective settings efficiently.

### **Model: `DeliveryType`**

```php 
class DeliverType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'cash'
    ];
}
```

purpose
- This model ensures that the system can accommodate and differentiate between different delivery service providers.

###**Feature Work**
This model can be extended in the future to include additional attributes, such as:
- Commission Rates: To track and manage the commission for each delivery service.
- Delivery Charges: To specify service-specific delivery fees.


