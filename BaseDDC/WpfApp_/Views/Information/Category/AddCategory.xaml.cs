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
    public partial class AddCategory : Window
    {
        public List<string> all_categories;

        public AddCategory(List<DTO_Category> categories_list)
        {
            InitializeComponent();
            all_categories = new List<string>();
            categories_list.ForEach((item) => all_categories.Add(item.title));
        }

        private void Add_Click(object sender, RoutedEventArgs e)
        {
            try
            {
                if (CategoryName.Equals("") || CategoryName.Equals(" ")) throw new Exception("Поле не заполнено");
                if (all_categories.Contains(CategoryName.Text)) throw new Exception("Такая категория существует");

                var result = RestAPI.PostRest("/Category/Add", new DTO_Category() { title = CategoryName.Text });
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
