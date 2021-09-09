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
    public partial class EditNeed : Window
    {
        public List<string> all_needs;
        private DTO_Need edit_need;

        public EditNeed(List<DTO_Need> needs_list, DTO_Need need)
        {
            InitializeComponent();
            NeedName.Text = need.title;
            edit_need = need;
            all_needs = new List<string>();
            needs_list.ForEach((item) => all_needs.Add(item.title));
        }

        private void Edit_Click(object sender, RoutedEventArgs e)
        {
            try
            {
                if (NeedName.Equals("") || NeedName.Equals(" ")) throw new Exception("Поле не заполнено");
                if (all_needs.Contains(NeedName.Text)) throw new Exception("Такая нужда существует");

                edit_need.title = NeedName.Text;
                var result = RestAPI.PostRest("/Need/Edit",edit_need);
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
