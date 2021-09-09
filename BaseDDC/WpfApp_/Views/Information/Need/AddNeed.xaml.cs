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

namespace DDC_App.Views.Information.Need
{
    /// <summary>
    /// Логика взаимодействия для AddCategory.xaml
    /// </summary>
    public partial class AddNeed : Window
    {
        public List<string> all_needs;

        public AddNeed(List<DTO_Need> needs_list)
        {
            InitializeComponent();
            all_needs = new List<string>();
            needs_list.ForEach((item) => all_needs.Add(item.title));
        }

        private void Add_Click(object sender, RoutedEventArgs e)
        {
            try
            {
                if (NeedName.Equals("") || NeedName.Equals(" ")) throw new Exception("Поле не заполнено");
                if (all_needs.Contains(NeedName.Text)) throw new Exception("Такая нужда существует");

                var result = RestAPI.PostRest("/Need/Add", new DTO_Need() { title = NeedName.Text });
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
