using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;
using WpfApp_;
using BaseDTO;

namespace DDC_App.Views.Information.Category
{
    /// <summary>
    /// Логика взаимодействия для AddCategory.xaml
    /// </summary>
    public partial class EditCategory : Window
    {
        public List<string> all_categories;
        private DTO_Category edit_category;
        public EditCategory (List<DTO_Category> categories_list, DTO_Category category)
        {
            InitializeComponent();
            CategoryName.Text = category.title;
            edit_category = category;
            all_categories = new List<string>();
            categories_list.ForEach((item) => all_categories.Add(item.title));
        }

        private void Edit_Click(object sender, RoutedEventArgs e)
        {
            try
            {
                if (CategoryName.Equals("") || CategoryName.Equals(" ")) throw new Exception("Поле не заполнено");
                if (all_categories.Contains(CategoryName.Text)) throw new Exception("Такая категория существует");
                edit_category.title = CategoryName.Text;
                var result = RestAPI.PostRest("/Category/Edit", edit_category);
                this.Close();
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "Ошибка");
            }
        }

        private void Cancel_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
        }

    }
}
